/*
 * Solver accept both array like object and objects with associative keys
 */
function Solver(expression, operations)
{
    this.operand1 = this.operator = this.operand2 = false;
    let thisSolver = this;

    this.operations = typeof operations === 'undefined' ? { 'plus': function(n1, n2) {return n1 + n2;},
                                                            'minus': function(n1, n2) {return n1 - n2;},
                                                            'times': function(n1, n2) {return n1 * n2;},
                                                            'divide': function(n1, n2) {return n1 / n2;} }
                                                        : operations;


    let getOperand = function(operand) {
        // if recursive
        if (typeof operand === 'object') {
            // pass operations here ensure new operation should also be available for recursive Solver
            let solver = new Solver(operand, thisSolver.operations);
            return solver.calculate();
        }

        return operand;
    };


    // read expression, and set values for operands and operator
    let readExpression = function() {
        // checking element index 0 or operand1
        if (typeof expression === 'object' && expression.hasOwnProperty('operand1')) {
            thisSolver.operand1 = getOperand(expression.operand1);
        } else if (Array.isArray(expression) && expression.length === 3) {
            thisSolver.operand1 = getOperand(expression[0]);
        }

        // checking element index 1 or operator
        if (typeof expression === 'object' && expression.hasOwnProperty('operator')) {
            // only set value to operator if it is string
            thisSolver.operator = typeof expression.operator === 'string' || expression.operator instanceof String
                ? expression.operator : thisSolver.operator;

        } else if (Array.isArray(expression) && expression.length === 3) {
            thisSolver.operator = expression[1];
        }

        // checking element index 0 or operand2
        if (typeof expression === 'object' && expression.hasOwnProperty('operand2')) {
            thisSolver.operand2 = getOperand(expression.operand2);
        } else if (Array.isArray(expression) && expression.length === 3) {
            thisSolver.operand2 = getOperand(expression[2]);
        }
    };


    // calculate the result
    this.calculate = function() {
        readExpression();

        // if not well-formed, return false
        if (thisSolver.operand1 === false || thisSolver.operator === false || thisSolver.operand2 === false) {
            return false;
        }

        // loop operations if any one matched operator, return operation function
        for (let operation in thisSolver.operations) {
            if (operation == thisSolver.operator.toLowerCase()) {
                return thisSolver.operations[operation](thisSolver.operand1, thisSolver.operand2);
            }
        }

        return false; // return false if no operation found
    };


    // add operation
    this.addOperation = function(name, func) {
        thisSolver.operations[name.toLowerCase()] = func;
        return this;
    };
}