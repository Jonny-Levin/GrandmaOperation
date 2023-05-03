<?php

/** @var yii\web\View $this */

$this->title = 'Grandma Operation';
?>

<html>
    <head>
        <style>
            body {
                background-color:azure;
                font-family: Arial, Helvetica, sans-serif;
            }
            
            .soundButton {
                height: 33%;
                width: 33%;  
                src: "/images/SoundButton.png";
            }

            .deliverButton {
                height: 33%;
                width: 33%; 
                src: "/images/DeliverButton.png";
            }
            
            .container {
                margin: left;
            }
            .slider {
                width: 75%;
                max-width: 325px;
                height: 10px;
                border-radius: 5px;  
                background: #0420aa;
                outline: none;
                opacity: 0.7;
                -webkit-transition: .2s;
                transition: opacity .2s;
            }

            .slider::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 25px;
                height: 25px;
                border-radius: 50%; 
                background: #0420aa;
                cursor: pointer;
            }

            .slider::-moz-range-thumb {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background: #0420aa;
                cursor: pointer;
            }
        </style>
    </head>

    <body> 
        <div class="container">
            <h1> Hearing Test </h1>
            
            <div class="soundButton" onclick="soundButtonClick()">
                <p> 1. Click to play the sound: 
                    <button>
                        <img src = "/images/SoundButton.png" alt=SoundButton width="20" height="16"> 
                    </button>
                </p>
            </div>
            
            <p> 2. Move the slider untill you start hearing a sound: </p>

            <div class="slidecontainer">
                <input type="range" min="0" max="10000" value="0" class="slider" id="myRange"/>
                <p hidden> Value: <span id="output"></span> </p>
            </div>
            
            <br>
            <div class="deliverButton" onclick="deliverButtonClick()">
                <button style="font-size:16px;">
                    <img src = "/images/DeliverButton.png" width="16" height="16"> Submit Results
                </button>
            </div>
            
            
            <script>
                var slider = document.getElementById("myRange");
                var output = document.getElementById("output");
                var audioCtx;
                var oscillator;
                var isSoundOn = false;
                
                output.innerHTML = slider.value; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider.oninput = function() {
                    output.innerHTML = 20000 - this.value;
                } 

                
                function soundButtonClick() {
                        
                        if (!audioCtx) {
                            initAudioContext();
                        }
                        
                        if(!isSoundOn) {
                            oscillator.start();
                            isSoundOn = true;
                        }
                        else {
                            oscillator.stop();
                            isSoundOn = false;
                            oscillator = createOscillatorNode();
                        }

                        slider.addEventListener('input', function() {
                            oscillator.frequency.setValueAtTime(output.innerHTML, audioCtx.currentTime);
                        });
                }
                    
                function initAudioContext() {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    oscillator = createOscillatorNode();
                }

                function createOscillatorNode() {
                    const oscillator = audioCtx.createOscillator();
                    oscillator.type = 'sawtooth';
                    oscillator.frequency.setValueAtTime(output.innerHTML, audioCtx.currentTime); // value in hertz
                    oscillator.connect(audioCtx.destination);
                    return oscillator;
                }

                function deliverButtonClick() {
                    var xhr = new (window.XMLHttpRequest || window.ActiveXObject)();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if(xhr.status === 200) {
                                // AJAX request was successful
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    alert("Data saved successfully");
                                } 
                                else {
                                    alert("Data not saved");
                                    console.log(response);
                                }
                            } 
                            else {
                                alert("Request failed, please try again");
                            }
                        };
                    }
                    
                    xhr.open("POST", "save_results.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    if (0 != output.innerHTML && audioCtx) {
                        <?php if(!Yii::$app->user->isGuest): ?>
                            xhr.send("value=" + output.innerHTML);
                        <?php else: ?>
                            alert("Please log in first");
                        <?php endif; ?>
                    }
                    else {
                        alert("Submition failed:\nMake sure to click the sound button and move the slider first!");
                    }
                }
            </script>
        </div>
    </body>
</html>