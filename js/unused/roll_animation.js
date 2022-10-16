// to disable roll button during animation
var flag = true;
$('.btn-roll').on('click', function(){
	flag = false;
});

// ======= roll animation =======
var targetDigit = document.getElementById("roleta-container").getAttribute("data-digit");
var targetDigitArray = Array.from(String(targetDigit), Number);

var targetDigit_kvp = {
    0: targetDigitArray[targetDigitArray.length-2],
    1: targetDigitArray[targetDigitArray.length-1]
};

var seed = "";
var delay = 1; //Delay In Ticks
var amount = 100; //How Many Times It Generates A Number Before Moving On To The Next
var numLength = 2;

var amountNum = 0;
var frameNum = 0;
var numPosition = 0;
var body = document.getElementById("roleta-container");
var rng = new Math.seedrandom(seed);

for (i = 0; i < numLength; i++) {
	body.innerHTML += "<code style='font-size: 5rem;'>0</code>";
}

var numbers = document.getElementsByTagName("code");

function AnimateRoll() {
	frameNum++;
	if (frameNum > delay) {
		amountNum++;
		frameNum = 0;
		for (i = numPosition; i < numLength; i++) {
			numbers[i].innerHTML = Math.floor(rng() * 10);
		}
	}
	if (amountNum > amount && numbers[numPosition].innerHTML == targetDigit_kvp[numPosition]) {
		numPosition++;
		amountNum = 0;
	}
	if (numPosition < numLength) {
		requestAnimationFrame(AnimateRoll);
	} else {
		numPosition = 0;
	}
}

function DisableRollButton() {
	$('.btn-roll').addClass('disabled');
}

function EnableRollButton() {
	$('.btn-roll').removeClass('disabled');
}

if (!flag) {
	DisableRollButton();
}
AnimateRoll();
EnableRollButton();