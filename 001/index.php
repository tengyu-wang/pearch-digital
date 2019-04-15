<!DOCTYPE html>
<html>
<head>
    <script src="js/solver.js"></script>
    <script>

        // Test solver.js here!
        document.addEventListener("DOMContentLoaded", function() {

            // Arg passed in is an object with keys 'operand1', 'operator' and 'operand2'
            let solver = new Solver([[5, "Plus", 6],
                                     "Times",
                                     [18, "divide", [4, "Plus", 2]]]);

            document.getElementById('result_1').innerHTML = solver.calculate();


            // Arg passed in is an 'array like' object
            solver = new Solver({operand1:8,
                                 operator:"Times",
                                 operand2:6});

            document.getElementById('result_2').innerHTML = solver.calculate();


            // Add an operation (Modulo %)
            solver = new Solver({operand1:{operand1:2, operator:"Plus", operand2:5},
                                 operator:"Times",
                                 operand2:{operand1:6, operator:"Modulo", operand2:4}});

            document.getElementById('result_3').innerHTML = solver.addOperation('Modulo', function(n1, n2) {return n1 % n2;})
                                                                  .calculate();
        });

    </script>
</head>
<body>
    <h1>Question 001 and 001(a): </h1>
    <h2>(with three test cases)</h2>
    <p>
        <span id="expression_1">(5 + 6) * (18 / (4 + 2)) = </span><span id="result_1"></span>
    </p>
    <p>
        <span id="expression_2"></span>8 * 6 = <span id="result_2"></span>
    </p>
    <p>
        <span id="expression_3"></span>(2 + 5) * (6 % 4) = <span id="result_3"></span>
    </p>
</body>
</html>