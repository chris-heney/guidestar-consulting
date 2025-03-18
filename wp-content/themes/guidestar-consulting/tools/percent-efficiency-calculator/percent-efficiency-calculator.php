<?php

add_shortcode("percent-efficiency-calculator", function ($atts) {
    ob_start();
    ?>
    <style>
        /* Add your CSS styles here */
        #efficiency-calculator {
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 500px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .input-group {
            margin-bottom: 10px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button-container {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        #clear-btn {
            background-color: gray;
            color: white;
        }
        #save-btn {
            background-color: blue;
            color: white;
        }
        .result {
            font-size: 18px;
            margin-top: 15px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input1 = document.getElementById('input1');
            const input2 = document.getElementById('input2');
            const calculateBtn = document.getElementById('calculate-btn');
            const resultDiv = document.getElementById('result');
            const clearBtn = document.getElementById('clear-btn');

            // Calculate efficiency when button is clicked
            calculateBtn.addEventListener('click', function() {
                const value1 = parseFloat(input1.value);
                const value2 = parseFloat(input2.value);

                if (!isNaN(value1) && !isNaN(value2) && value2 !== 0) {
                    const efficiency = ((value1 - value2) / value1) * 100;
                    resultDiv.textContent = `Efficiency: ${efficiency.toFixed(2)}%`;
                } else {
                    resultDiv.textContent = 'Invalid input. Please enter valid numbers.';
                }
            });

            // Clear inputs and result
            clearBtn.addEventListener('click', function() {
                input1.value = '';
                input2.value = '';
                resultDiv.textContent = '';
            });
        });
    </script>

    <div id="efficiency-calculator">
        <h3>Percent Efficiency</h3>
        <div class="input-group">
            <label for="input1">Influent</label>
            <input type="number" id="input1" placeholder="Enter Influent value">
        </div>
        <div class="input-group">
            <label for="input2">Effluent</label>
            <input type="number" id="input2" placeholder="Enter Effluent value">
        </div>

        <button id="calculate-btn">Calculate Efficiency</button>

        <div id="result" class="result"></div>

        <div class="button-container">
            <button id="clear-btn">CLEAR</button>
            <button id="save-btn">SAVE</button>
        </div>
    </div>

    <?php
    return ob_get_clean();
});
?>
