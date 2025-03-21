<?php

add_shortcode("disinfection-dosing-calculator", function ($atts) {
    ob_start();
    ?>
    <style>
        /* Consistent styling for the disinfection dosing calculator */
        #ddc-disinfection-dosing-calculator {
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

        #ddc-clear-btn {
            background-color: gray;
            color: white;
        }

        #ddc-calculate-btn {
            background-color: blue;
            color: white;
        }

        .ddc-result {
            font-size: 18px;
            margin-top: 15px;
            color: black;
        }

        .ddc-info-icon {
            cursor: pointer;
            font-size: 22px;
            color: #007BFF;
            margin-left: 10px;
            vertical-align: middle;
        }

        /* Modal styling */
        .ddc-modal {
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

        .ddc-modal-content {
            background-color: #333;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .ddc-modal-content h4 {
            color: white;
            margin-bottom: 15px;
        }

        .ddc-modal-content button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .ddc-modal-content p {
            color: green;
            text-align: left;
        }
    </style>

    <div id="ddc-disinfection-dosing-calculator">
        <h3>Disinfection Dosing
            <i class="fa fa-info-circle ddc-info-icon" onclick="showDdcModal()"></i>
        </h3>

        <div class="input-group">
            <label for="ddc-system-type">System Type</label>
            <select id="ddc-system-type" onchange="updateFields()">
                <option value="pipe">Pipe</option>
                <option value="tank">Tank</option>
                <option value="well-casing">Well Casing</option>
            </select>
        </div>

        <div id="pipe-fields" class="ddc-system-fields">
            <div class="input-group">
                <label for="ddc-pipe-diameter">Diameter (in)</label>
                <input type="number" id="ddc-pipe-diameter" placeholder="Enter pipe diameter">
            </div>
            <div class="input-group">
                <label for="ddc-pipe-length">Length (ft)</label>
                <input type="number" id="ddc-pipe-length" placeholder="Enter pipe length">
            </div>
        </div>

        <div id="tank-fields" class="ddc-system-fields" style="display: none;">
            <div class="input-group">
                <label for="ddc-tank-capacity">Capacity (gal)</label>
                <input type="number" id="ddc-tank-capacity" placeholder="Enter tank capacity">
            </div>
        </div>

        <div id="well-casing-fields" class="ddc-system-fields" style="display: none;">
            <div class="input-group">
                <label for="ddc-well-diameter">Diameter (in)</label>
                <input type="number" id="ddc-well-diameter" placeholder="Enter well casing diameter">
            </div>
            <div class="input-group">
                <label for="ddc-well-depth">Depth (ft)</label>
                <input type="number" id="ddc-well-depth" placeholder="Enter well depth">
            </div>
            <div class="input-group">
                <label for="ddc-well-length">Length (ft)</label>
                <input type="number" id="ddc-well-length" placeholder="Enter well length">
            </div>
        </div>

        <div class="input-group">
            <label for="ddc-strength">Desired Strength (ppm)</label>
            <input type="number" id="ddc-strength" placeholder="Enter desired strength">
        </div>

        <button id="ddc-calculate-btn">Calculate Dosing</button>
        <div id="ddc-result" class="ddc-result"></div>
        <div class="button-container">
            <button id="ddc-clear-btn">Clear</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="ddc-info-modal" class="ddc-modal">
        <div class="ddc-modal-content">
            <h4>How to Use the Disinfection Dosing Calculator</h4>
            <p>Select the system type (Pipe, Tank, or Well Casing), and then enter the required parameters for each system type.</p>
            <p>The calculator will compute the appropriate disinfectant dosing based on your input values.</p>
            <button onclick="closeDdcModal()">Close</button>
        </div>
    </div>

    <script>
        // Show modal with info
        function showDdcModal() {
            document.getElementById('ddc-info-modal').style.display = 'flex';
        }

        // Close modal
        function closeDdcModal() {
            document.getElementById('ddc-info-modal').style.display = 'none';
        }

        function updateFields() {
            const systemType = document.getElementById('ddc-system-type').value;
            const pipeFields = document.getElementById('pipe-fields');
            const tankFields = document.getElementById('tank-fields');
            const wellCasingFields = document.getElementById('well-casing-fields');

            pipeFields.style.display = 'none';
            tankFields.style.display = 'none';
            wellCasingFields.style.display = 'none';

            if (systemType === 'pipe') {
                pipeFields.style.display = 'block';
            } else if (systemType === 'tank') {
                tankFields.style.display = 'block';
            } else if (systemType === 'well-casing') {
                wellCasingFields.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateFields();  // Initial call to show default fields
        });

        document.getElementById('ddc-calculate-btn').addEventListener('click', function () {
            const systemType = document.getElementById('ddc-system-type').value;
            let resultText = '';

            if (systemType === 'pipe') {
                const diameter = parseFloat(document.getElementById('ddc-pipe-diameter').value);
                const length = parseFloat(document.getElementById('ddc-pipe-length').value);
                const strength = parseFloat(document.getElementById('ddc-strength').value);

                if (!isNaN(diameter) && !isNaN(length) && !isNaN(strength)) {
                    // Calculate dosing for pipe (placeholder logic)
                    resultText = `Calculated Dosing for Pipe: ${diameter * length * strength}`;
                }
            } else if (systemType === 'tank') {
                const capacity = parseFloat(document.getElementById('ddc-tank-capacity').value);
                const strength = parseFloat(document.getElementById('ddc-strength').value);

                if (!isNaN(capacity) && !isNaN(strength)) {
                    // Calculate dosing for tank (placeholder logic)
                    resultText = `Calculated Dosing for Tank: ${capacity * strength}`;
                }
            } else if (systemType === 'well-casing') {
                const diameter = parseFloat(document.getElementById('ddc-well-diameter').value);
                const depth = parseFloat(document.getElementById('ddc-well-depth').value);
                const length = parseFloat(document.getElementById('ddc-well-length').value);
                const strength = parseFloat(document.getElementById('ddc-strength').value);

                if (!isNaN(diameter) && !isNaN(depth) && !isNaN(length) && !isNaN(strength)) {
                    // Calculate dosing for well casing (placeholder logic)
                    resultText = `Calculated Dosing for Well Casing: ${diameter * depth * length * strength}`;
                }
            }

            if (resultText) {
                document.getElementById('ddc-result').textContent = resultText;
            } else {
                document.getElementById('ddc-result').textContent = 'Please fill in all fields with valid numbers.';
            }
        });

        document.getElementById('ddc-clear-btn').addEventListener('click', function () {
            document.querySelectorAll('.ddc-system-fields input').forEach(input => input.value = '');
            document.getElementById('ddc-result').textContent = '';
        });
    </script>

    <?php
    return ob_get_clean();
});
?>