<?php

add_shortcode("chemical-feed-adjustment-calculator", function ($atts) {
    ob_start();
    ?>
    <style>
        /* Styling for the chemical feed adjustment calculator */
        #cfa-chemical-feed-calculator {
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

        .input-group input, .input-group select {
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

        #cfa-clear-btn {
            background-color: gray;
            color: white;
        }

        #cfa-save-btn {
            background-color: blue;
            color: white;
        }

        .cfa-result {
            font-size: 18px;
            margin-top: 15px;
            color: black;
        }

        .cfa-info-icon {
            cursor: pointer;
            font-size: 22px;
            color: #007BFF;
            margin-left: 10px;
            vertical-align: middle;
        }

        /* Modal styling */
        .cfa-modal {
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

        .cfa-modal-content {
            background-color: #333;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .cfa-modal-content h4 {
            color: white;
            margin-bottom: 15px;
        }

        .cfa-modal-content button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .cfa-modal-content p {
            color: green;
            text-align: left;
        }
    </style>

    <div id="cfa-chemical-feed-calculator">
        <h3>Chemical Feed Adjustment
            <i class="fa fa-info-circle cfa-info-icon" onclick="showCfaModal()"></i>
        </h3>
        <div class="input-group">
            <label for="cfa-source-input">Source Input (GPM)</label>
            <input type="number" id="cfa-source-input" placeholder="Enter Source Input in GPM" required>
        </div>
        <div class="input-group">
            <label for="cfa-dosage">Required Dosage (PPM)</label>
            <input type="number" id="cfa-dosage" placeholder="Enter Required Dosage in PPM" required>
        </div>
        <div class="input-group">
            <label for="cfa-strength">Solution Strength (%)</label>
            <input type="number" id="cfa-strength" placeholder="Enter Solution Strength in %" required>
        </div>

        <button id="cfa-calculate-btn">Calculate Adjustment</button>

        <div id="cfa-result" class="cfa-result"></div>

        <div class="button-container">
            <button id="cfa-clear-btn">CLEAR</button>
            <button id="cfa-save-btn">SAVE</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="cfa-info-modal" class="cfa-modal">
        <div class="cfa-modal-content">
            <h4>How to Use the Chemical Feed Adjustment Calculator</h4>
            <p>Enter the Source Input in GPM (Gallons per minute), the Required Dosage in PPM (Parts per million), and the Solution Strength as a percentage.</p>
            <p>The calculator will compute the adjusted chemical feed rate required based on these values.</p>
            <button onclick="closeCfaModal()">Close</button>
        </div>
    </div>

    <script>
        // Show modal with info
        function showCfaModal() {
            document.getElementById('cfa-info-modal').style.display = 'flex';
        }

        // Close modal
        function closeCfaModal() {
            document.getElementById('cfa-info-modal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sourceInput = document.getElementById('cfa-source-input');
            const dosage = document.getElementById('cfa-dosage');
            const strength = document.getElementById('cfa-strength');
            const calculateBtn = document.getElementById('cfa-calculate-btn');
            const resultDiv = document.getElementById('cfa-result');
            const clearBtn = document.getElementById('cfa-clear-btn');

            // Calculate chemical feed adjustment when button is clicked
            calculateBtn.addEventListener('click', function () {
                const source = parseFloat(sourceInput.value);
                const requiredDosage = parseFloat(dosage.value);
                const solutionStrength = parseFloat(strength.value);

                if (!isNaN(source) && !isNaN(requiredDosage) && !isNaN(solutionStrength) && source > 0 && solutionStrength > 0) {
                    // Chemical Feed Adjustment Formula
                    const adjustment = (requiredDosage * source) / (solutionStrength * 100);
                    resultDiv.textContent = `Adjusted Feed Rate: ${adjustment.toFixed(2)} Gallons per Minute (GPM)`;
                } else {
                    resultDiv.textContent = 'Please enter valid numbers in all fields.';
                }
            });

            // Clear inputs and result
            clearBtn.addEventListener('click', function () {
                sourceInput.value = '';
                dosage.value = '';
                strength.value = '';
                resultDiv.textContent = '';
            });
        });
    </script>

    <?php
    return ob_get_clean();
});
?>