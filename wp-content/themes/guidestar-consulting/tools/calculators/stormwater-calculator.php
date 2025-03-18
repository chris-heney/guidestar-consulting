<?php

add_shortcode("stormwater-calculator", function ($atts) {
    ob_start();
    ?>
    <style>
        /* Add styling for the Stormwater Calculator */
        #swc-stormwater-calculator {
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
        }

        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        #swc-clear-btn {
            background-color: gray;
            color: white;
        }

        #swc-calculate-btn {
            background-color: blue;
            color: white;
        }

        .swc-result {
            font-size: 18px;
            margin-top: 15px;
            color: black;
        }

        .swc-info-icon {
            cursor: pointer;
            font-size: 22px;
            color: #007BFF;
            margin-left: 10px;
            vertical-align: middle;
        }

        /* Modal styling */
        .swc-modal {
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

        .swc-modal-content {
            background-color: #333;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .swc-modal-content h4 {
            color: white;
            margin-bottom: 15px;
        }

        .swc-modal-content button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .swc-modal-content p {
            color: green;
            text-align: left;
        }
    </style>

    <div id="swc-stormwater-calculator">
        <h3>Stormwater Runoff Calculator
            <i class="fa fa-info-circle swc-info-icon" onclick="showSwcInfoModal()"></i>
        </h3>
        <div class="input-group">
            <label for="swc-area">Area (sq ft or sq m)</label>
            <input type="number" id="swc-area" placeholder="Enter Area" required>
        </div>
        <div class="input-group">
            <label for="swc-runoff-coefficient">Runoff Coefficient (C)</label>
            <input type="number" id="swc-runoff-coefficient" placeholder="Enter Runoff Coefficient" required>
        </div>
        <div class="input-group">
            <label for="swc-rainfall-intensity">Rainfall Intensity (inches/hour or mm/hour)</label>
            <input type="number" id="swc-rainfall-intensity" placeholder="Enter Rainfall Intensity" required>
        </div>

        <button id="swc-calculate-btn">Calculate Runoff Volume</button>

        <div id="swc-result" class="swc-result"></div>

        <div class="button-container">
            <button id="swc-clear-btn">CLEAR</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="swc-info-modal" class="swc-modal">
        <div class="swc-modal-content">
            <h4>How to Use the Stormwater Runoff Calculator</h4>
            <p>Enter the Area of the site (in square feet or square meters), the Runoff Coefficient (C), and the Rainfall Intensity (in inches per hour or mm per hour).</p>
            <p>The calculator will compute the runoff volume based on these values.</p>
            <button onclick="closeSwcInfoModal()">Close</button>
        </div>
    </div>

    <script>
        // Show modal with info
        function showSwcInfoModal() {
            document.getElementById('swc-info-modal').style.display = 'flex';
        }

        // Close modal
        function closeSwcInfoModal() {
            document.getElementById('swc-info-modal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const area = document.getElementById('swc-area');
            const runoffCoefficient = document.getElementById('swc-runoff-coefficient');
            const rainfallIntensity = document.getElementById('swc-rainfall-intensity');
            const calculateBtn = document.getElementById('swc-calculate-btn');
            const resultDiv = document.getElementById('swc-result');
            const clearBtn = document.getElementById('swc-clear-btn');

            // Calculate Runoff Volume when button is clicked
            calculateBtn.addEventListener('click', function () {
                const areaValue = parseFloat(area.value);
                const runoffCoefficientValue = parseFloat(runoffCoefficient.value);
                const rainfallIntensityValue = parseFloat(rainfallIntensity.value);

                if (!isNaN(areaValue) && !isNaN(runoffCoefficientValue) && !isNaN(rainfallIntensityValue)) {
                    const runoffVolume = runoffCoefficientValue * rainfallIntensityValue * areaValue;
                    resultDiv.textContent = `Runoff Volume: ${runoffVolume.toFixed(2)} cubic feet or liters`;
                } else {
                    resultDiv.textContent = 'Please enter valid numbers in all fields.';
                }
            });

            // Clear inputs and result
            clearBtn.addEventListener('click', function () {
                area.value = '';
                runoffCoefficient.value = '';
                rainfallIntensity.value = '';
                resultDiv.textContent = '';
            });
        });
    </script>

    <?php
    return ob_get_clean();
});
?>