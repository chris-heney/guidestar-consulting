<?php

add_shortcode("percent-efficiency-calculator", function ($atts) {
    ob_start();
    ?>
    <style>
        /* Add your CSS styles here */
        #pe-efficiency-calculator {
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 500px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 100%;
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
            padding: 0 5px;
        }

        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        #pe-clear-btn {
            background-color: gray;
            color: white;
        }

        #pe-save-btn {
            background-color: blue;
            color: white;
        }

        .pe-result {
            font-size: 18px;
            margin-top: 15px;
            color: black;
        }

        .pe-info-icon {
            cursor: pointer;
            font-size: 22px;
            color: #007BFF;
            margin-left: 10px;
            vertical-align: middle;
        }

        .pe-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1000;
        }

        .pe-modal-content {
            background-color: #333;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .pe-modal-content h4 {
            color: white;
            margin-bottom: 15px;
        }

        .pe-modal-content button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .pe-modal-content p {
            color: green;
            text-align: left;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <div id="pe-efficiency-calculator">
        <h3>Percent Efficiency
            <i class="fa fa-info-circle pe-info-icon" onclick="showPeModal()"></i>
        </h3>
        <div class="input-group">
            <label for="pe-input1">Influent</label>
            <input type="number" id="pe-input1" placeholder="Enter Influent value" required>
        </div>
        <div class="input-group">
            <label for="pe-input2">Effluent</label>
            <input type="number" id="pe-input2" placeholder="Enter Effluent value" required>
        </div>

        <button id="pe-calculate-btn">Calculate Efficiency</button>

        <div id="pe-result" class="pe-result"></div>

        <div class="button-container">
            <button id="pe-clear-btn">CLEAR</button>
            <button id="pe-save-btn">SAVE</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="pe-info-modal" class="pe-modal">
        <div class="pe-modal-content">
            <h4>How to Use the Percent Efficiency Calculator</h4>
            <p>Enter the values for Influent (input value before treatment) and Effluent (output value after treatment).</p>
            <p>The calculator will compute the efficiency of the process based on these two values.</p>
            <div style="display: flex; justify-content: flex-end">
                <button onclick="closePeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Show modal with info
        function showPeModal() {
            document.getElementById('pe-info-modal').style.display = 'flex';
        }

        // Close modal
        function closePeModal() {
            document.getElementById('pe-info-modal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const input1 = document.getElementById('pe-input1');
            const input2 = document.getElementById('pe-input2');
            const calculateBtn = document.getElementById('pe-calculate-btn');
            const resultDiv = document.getElementById('pe-result');
            const clearBtn = document.getElementById('pe-clear-btn');

            // Calculate efficiency when button is clicked
            calculateBtn.addEventListener('click', function () {
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
            clearBtn.addEventListener('click', function () {
                input1.value = '';
                input2.value = '';
                resultDiv.textContent = '';
            });
        });
    </script>

    <?php
    return ob_get_clean();
});
?>