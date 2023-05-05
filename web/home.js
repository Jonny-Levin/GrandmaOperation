const slider = document.getElementById("myRange");
const output = document.getElementById("output");
let audioCtx;
let oscillator;
let isSoundOn = false;

// output.innerHTML = slider.value; // Display the default slider value 
/* maybe redundant */

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
    const xhr = new (window.XMLHttpRequest || window.ActiveXObject)();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if(xhr.status === 200) {
                // AJAX request was successful
                const response = JSON.parse(xhr.responseText);
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
        // <?php if(!Yii::$app->user->isGuest): ?>
            xhr.send("value=" + output.innerHTML);
        // <?php else: ?>
        //     alert("Please log in first");
        // <?php endif; ?>
    }
    else {
        alert("Submition failed:\nMake sure to click the sound button and move the slider first!");
    }
}
