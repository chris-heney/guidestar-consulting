<?php

add_shortcode("calculator-list", function ($atts) {
    ob_start();
    ?>
    <div id="calculator-container" style="padding: 20px; color: white; border-radius: 10px;">
        <!-- Left Side: Calculator List -->
        <div>
            <h3 style="margin-bottom: 20px; color: #D4AF37;">Select a Calculator</h3>
            <div style="margin-bottom: 10px;">
                <button onclick="showCalculator('avg-annual-water-loss')" class="calculator-btn">Avg Annual Water
                    Loss</button>
            </div>
            <div style="margin-bottom: 10px;">
                <button onclick="showCalculator('chemical-feed-calculator')" class="calculator-btn">Chemical Feed
                    Calculator</button>
            </div>
            <div style="margin-bottom: 10px;">
                <button onclick="showCalculator('percent-efficiency-calculator')" class="calculator-btn">Percent Efficiency
                    Calculator</button>
            </div>
            <div style="margin-bottom: 10px;">
                <button onclick="showCalculator('stormwater-calculator')" class="calculator-btn">Stormwater
                    Calculator</button>
            </div>
            <div style="margin-bottom: 10px;">
                <button onclick="showCalculator('disinfection-dosing-calculator')" class="calculator-btn">
                    Disinfection Dosing Calculator
                </button>
            </div>
        </div>

        <!-- Right Side: Calculator Display -->
        <div id="calculator-display"
            style="border-radius: 8px; padding: 20px; color: white; min-height: 300px;">
            <!-- Default to show Avg Annual Water Loss -->
            <div id="avg-annual-water-loss" class="calculator-content" style="display: block;">
                <?php echo do_shortcode('[avg-annual-water-loss]'); ?>
            </div>
            <div id="chemical-feed-calculator" class="calculator-content" style="display: none;">
                <?php echo do_shortcode('[chemical-feed-adjustment-calculator]'); ?>
            </div>
            <div id="percent-efficiency-calculator" class="calculator-content" style="display: none;">
                <?php echo do_shortcode('[percent-efficiency-calculator]'); ?>
            </div>
            <div id="stormwater-calculator" class="calculator-content" style="display: none;">
                <?php echo do_shortcode('[stormwater-calculator]'); ?>
            </div>
            <div id="disinfection-dosing-calculator" class="calculator-content" style="display: none;">
                <?php echo do_shortcode('[disinfection-dosing-calculator]'); ?>
            </div>
        </div>
    </div>

    <script>
        function showCalculator(calculatorName) {
            // Hide all calculators
            const calculators = document.querySelectorAll('.calculator-content');
            calculators.forEach(calculator => {
                calculator.style.display = 'none';
            });

            // Show the selected calculator
            const selectedCalculator = document.getElementById(calculatorName);
            if (selectedCalculator) {
                selectedCalculator.style.display = 'block';
            }
        }
    </script>

    <style>
        .calculator-btn {
            padding: 12px 20px;
            background-color: #4B8F29;
            /* Matching brand color */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .calculator-btn:hover {
            background-color: #2F6A1F;
            /* Slightly darker for hover effect */
        }

        #calculator-list {
            list-style-type: none;
            padding: 0;
        }

        #calculator-list li {
            margin-bottom: 20px;
        }

        #calculator-container {
            max-width: "100%";
            border-radius: 10px;
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        #calculator-display {
            margin-top: 50px;
            padding: 20px;
            border-radius: 8px;
            color: white;
            min-height: 300px;
        }
    </style>

    <?php
    return ob_get_clean();
});
?>