
  (function() {
    const display = document.getElementById('display');
    const buttons = document.querySelectorAll('button');
    let currentInput = '0';
    let lastInputIsOperator = false;
    let decimalAdded = false;

    function updateDisplay() {
      display.textContent = currentInput;
    }

    function isOperator(char) {
      return char === '+' || char === '-' || char === '*' || char === '/';
    }

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const num = button.getAttribute('data-num');
        const op = button.getAttribute('data-op');
        const id = button.id;

        if (id === 'clear') {
          currentInput = '0';
          decimalAdded = false;
          lastInputIsOperator = false;
          updateDisplay();
          return;
        }

        if (id === 'backspace') {
          if (currentInput.length > 1) {
            if (currentInput.slice(-1) === '.') {
              decimalAdded = false;
            }
            currentInput = currentInput.slice(0, -1);
            decimalAdded = currentInput.includes('.');
            lastInputIsOperator = isOperator(currentInput.slice(-1));
          } else {
            currentInput = '0';
            decimalAdded = false;
            lastInputIsOperator = false;
          }
          updateDisplay();
          return;
        }

        if (op) {
          if (lastInputIsOperator) {
            currentInput = currentInput.slice(0, -1) + op;
          } else {
            currentInput += op;
            decimalAdded = false;
          }
          lastInputIsOperator = true;
          updateDisplay();
          return;
        }

        if (num) {
          if (num === '.') {
            if (!decimalAdded) {
              if (lastInputIsOperator || currentInput === '') {
                currentInput += '0.';
              } else {
                currentInput += '.';
              }
              decimalAdded = true;
              lastInputIsOperator = false;
            }
          } else {
            if (currentInput === '0' && num !== '.') {
              currentInput = num;
            } else {
              currentInput += num;
            }
            lastInputIsOperator = false;
          }
          updateDisplay();
          return;
        }

        if (id === 'equals') {
          try {
            let result = evaluateExpression(currentInput);
            currentInput = result.toString();
            decimalAdded = currentInput.includes('.');
            lastInputIsOperator = false;
            updateDisplay();
          } catch (e) {
            currentInput = 'Infinity';
            updateDisplay();
          }
          return;
        }
      });
    });

    function evaluateExpression(expr) {
      let tokens = [];
      let numberBuffer = '';

      for (let i = 0; i < expr.length; i++) {
        let ch = expr[i];
        if ('0123456789.'.indexOf(ch) !== -1) {
          numberBuffer += ch;
        } else if ('+-*/'.indexOf(ch) !== -1) {
          if (numberBuffer === '') {
            if (ch === '-' && (i === 0 || '+-*/'.indexOf(expr[i-1]) !== -1)) {
              numberBuffer = '-';
            } else {
              throw new Error('Invalid expression');
            }
          } else {
            tokens.push(parseFloat(numberBuffer));
            numberBuffer = '';
            tokens.push(ch);
          }
        } else {
          throw new Error('Invalid character');
        }
      }
      if (numberBuffer !== '') {
        tokens.push(parseFloat(numberBuffer));
      }

      function parseTerm(tokens) {
        let value = tokens.shift();

        while (tokens.length > 0 && (tokens[0] === '*' || tokens[0] === '/')) {
          let op = tokens.shift();
          let nextValue = tokens.shift();
          if (op === '*') {
            value = value * nextValue;
          } else {
            if (nextValue === 0) {
              throw new Error('Division by zero');
            }
            value = value / nextValue;
          }
        }
        return value;
      }

      function parseExpression(tokens) {
        let value = parseTerm(tokens);

        while (tokens.length > 0 && (tokens[0] === '+' || tokens[0] === '-')) {
          let op = tokens.shift();
          let nextTerm = parseTerm(tokens);
          if (op === '+') {
            value = value + nextTerm;
          } else {
            value = value - nextTerm;
          }
        }
        return value;
      }

      return parseExpression(tokens.slice());
    }
  })();
