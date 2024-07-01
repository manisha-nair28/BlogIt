//  Speech Synthesis Script

let speechSynthesisUtterance;


function speakPost() {
    const title = document.getElementById('post-title').innerText;
    const content = document.getElementById('post-content').innerText;

    // Cancel the current speech if it is speaking
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
    }

    speechSynthesisUtterance = new SpeechSynthesisUtterance();
    speechSynthesisUtterance.text = `${title}. ${content}`;
    speechSynthesisUtterance.volume = 1;
    speechSynthesisUtterance.rate = 1;
    speechSynthesisUtterance.pitch = 1;

    window.speechSynthesis.speak(speechSynthesisUtterance);

    // Show the pause button and hide the read button
    document.getElementById('readButton').style.display = 'none';
    document.getElementById('pauseButton').style.display = 'inline';
}

function pauseSpeech() {
    if (speechSynthesisUtterance) {
        window.speechSynthesis.pause();
        // Show the resume button and hide the pause button
        document.getElementById('pauseButton').style.display = 'none';
        document.getElementById('resumeButton').style.display = 'inline';
    }
}

function resumeSpeech() {
    if (speechSynthesisUtterance) {
        window.speechSynthesis.resume();
        // Show the pause button and hide the resume button
        document.getElementById('resumeButton').style.display = 'none';
        document.getElementById('pauseButton').style.display = 'inline';
    }
}



// Add this at the end of your script
window.onbeforeunload = function() {
    // Cancel the speech synthesis when the user navigates away from the page
    window.speechSynthesis.cancel();
};
