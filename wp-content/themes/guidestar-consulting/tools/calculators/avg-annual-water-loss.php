<?php

add_shortcode("avg-annual-water-loss", function ($atts) {
    ob_start();
    ?>
    <style>
        #water-loss-calculator {
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 500px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        #clear-btn {
            background-color: gray;
            color: white;
        }

        #calculate-btn {
            background-color: blue;
            color: white;
        }

        .result {
            font-size: 18px;
            margin-top: 15px;
            color: black;
        }

        .info-icon {
            cursor: pointer;
            font-size: 22px;
            color: #007BFF;
            margin-left: 10px;
            vertical-align: middle;
        }

        .modal {
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

        .modal-content {
            background-color: #333;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .modal-content h4 {
            color: white;
            margin-bottom: 15px;
        }

        .modal-content button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .modal-content p {
            color: green;
            text-align: left;
        }
    </style>

    <div id="water-loss-calculator">
        <h3>Avg Annual Water Loss
            <i class="fa fa-info-circle info-icon" onclick="showWaterLossModal()"></i>
        </h3>
        <p>Calculate average annual water loss. Any fields with no input will default to 0%.</p>
        <div class="input-group">
            <label for="jan-loss">January Loss %</label>
            <input type="number" id="jan-loss" placeholder="Enter January Loss %">
        </div>
        <div class="input-group">
            <label for="feb-loss">February Loss %</label>
            <input type="number" id="feb-loss" placeholder="Enter February Loss %">
        </div>
        <div class="input-group">
            <label for="mar-loss">March Loss %</label>
            <input type="number" id="mar-loss" placeholder="Enter March Loss %">
        </div>
        <div class="input-group">
            <label for="apr-loss">April Loss %</label>
            <input type="number" id="apr-loss" placeholder="Enter April Loss %">
        </div>
        <div class="input-group">
            <label for="may-loss">May Loss %</label>
            <input type="number" id="may-loss" placeholder="Enter May Loss %">
        </div>
        <div class="input-group">
            <label for="jun-loss">June Loss %</label>
            <input type="number" id="jun-loss" placeholder="Enter June Loss %">
        </div>
        <div class="input-group">
            <label for="jul-loss">July Loss %</label>
            <input type="number" id="jul-loss" placeholder="Enter July Loss %">
        </div>
        <div class="input-group">
            <label for="aug-loss">August Loss %</label>
            <input type="number" id="aug-loss" placeholder="Enter August Loss %">
        </div>
        <div class="input-group">
            <label for="sep-loss">September Loss %</label>
            <input type="number" id="sep-loss" placeholder="Enter September Loss %">
        </div>
        <div class="input-group">
            <label for="oct-loss">October Loss %</label>
            <input type="number" id="oct-loss" placeholder="Enter October Loss %">
        </div>
        <div class="input-group">
            <label for="nov-loss">November Loss %</label>
            <input type="number" id="nov-loss" placeholder="Enter November Loss %">
        </div>
        <div class="input-group">
            <label for="dec-loss">December Loss %</label>
            <input type="number" id="dec-loss" placeholder="Enter December Loss %">
        </div>

        <button id="calculate-btn">Calculate Average Loss</button>

        <div id="result" class="result"></div>

        <div class="button-container">
            <button id="clear-btn">CLEAR</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="waterLossModal" class="modal">
        <div class="modal-content">
            <h4>How to Use the Avg Annual Water Loss Calculator</h4>
            <p>Enter the monthly water loss percentages. Any field left empty will be treated as 0%. The calculator will compute the average of all entered values and display the result.</p>
            <button onclick="closeWaterLossModal()">Close</button>
        </div>
    </div>

    <script>
        // Show modal with info
        function showWaterLossModal() {
            document.getElementById('waterLossModal').style.display = 'flex';
        }

        // Close modal
        function closeWaterLossModal() {
            document.getElementById('waterLossModal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const months = [
                'jan', 'feb', 'mar', 'apr', 'may', 'jun',
                'jul', 'aug', 'sep', 'oct', 'nov', 'dec'
            ];

            const calculateBtn = document.getElementById('calculate-btn');
            const resultDiv = document.getElementById('result');
            const clearBtn = document.getElementById('clear-btn');

            // Calculate Average Loss when button is clicked
            calculateBtn.addEventListener('click', function () {
                let totalLoss = 0;
                let validEntries = 0;

                months.forEach(month => {
                    const input = document.getElementById(`${month}-loss`);
                    const value = parseFloat(input.value);

                    if (!isNaN(value)) {
                        totalLoss += value;
                        validEntries++;
                    }
                });

                if (validEntries > 0) {
                    const averageLoss = totalLoss / validEntries;
                    resultDiv.textContent = `Average Annual Water Loss: ${averageLoss.toFixed(2)}%`;
                } else {
                    resultDiv.textContent = 'Please enter valid values for at least one month.';
                }
            });

            // Clear inputs and result
            clearBtn.addEventListener('click', function () {
                months.forEach(month => {
                    const input = document.getElementById(`${month}-loss`);
                    input.value = '';
                });
                resultDiv.textContent = '';
            });
        });
    </script>

    <?php
    return ob_get_clean();
});
?>