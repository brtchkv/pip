let ctx = canvas[0].getContext("2d");

function drawStar(cx, cy, spikes, outerRadius, innerRadius) {
    var rot = Math.PI / 2 * 3;
    var x = cx;
    var y = cy;
    var step = Math.PI / spikes;

    ctx.beginPath();
    ctx.moveTo(cx, cy - outerRadius);
    for (i = 0; i < spikes; i++) {
        x = cx + Math.cos(rot) * outerRadius;
        y = cy + Math.sin(rot) * outerRadius;
        ctx.lineTo(x, y);
        rot += step;

        x = cx + Math.cos(rot) * innerRadius;
        y = cy + Math.sin(rot) * innerRadius;
        ctx.lineTo(x, y);
        rot += step
    }
    ctx.lineTo(cx, cy - outerRadius);
    ctx.closePath();
    ctx.lineWidth = 5;
    ctx.strokeStyle = 'blue';
    ctx.stroke();
    ctx.fillStyle = 'skyblue';
    ctx.fill();
}

var context;
var screenH;
var screenW;
var stars = [];
var fps = 50;
var numStars = 2000;

$('document').ready(function () {

    // Calculate the screen size
    screenH = canvas.height();
    screenW = canvas.width();


    // Fill out the canvas
    canvas.attr('height', screenH);
    canvas.attr('width', screenW);
    context = ctx;

    // Create all the stars
    for (var i = 0; i < numStars; i++) {
        var x = Math.round(Math.random() * screenW);
        var y = Math.round(Math.random() * screenH);
        var length = 1 + Math.random() * 2;
        var opacity = Math.random();

        // Create a new star and draw
        var star = new Star(x, y, length, opacity);

        // Add the the stars array
        stars.push(star);
    }

    setInterval(animate);
});

/**
 * Animate the canvas
 */
function animate() {
    context.clearRect(0, 0, screenW, screenH);
    $.each(stars, function () {
        this.draw(context);
    })
}

/**
 * Star
 *
 * @param int x
 * @param int y
 * @param int length
 * @param opacity
 */
function Star(x, y, length, opacity) {
    this.x = parseInt(x);
    this.y = parseInt(y);
    this.length = parseInt(length);
    this.opacity = opacity;
    this.factor = 1;
    this.increment = Math.random() * .03;
}

/**
 * Draw a star
 *
 * This function draws a start.
 * You need to give the contaxt as a parameter
 *
 * @param context
 */
Star.prototype.draw = function () {
    context.rotate((Math.PI * 1 / 10));

    // Save the context
    context.save();

    // move into the middle of the canvas, just to make room
    context.translate(this.x, this.y);

    // Change the opacity
    if (this.opacity > 1) {
        this.factor = -1;
    } else if (this.opacity <= 0) {
        this.factor = 1;

        this.x = Math.round(Math.random() * screenW);
        this.y = Math.round(Math.random() * screenH);
    }

    this.opacity += this.increment * this.factor;

    context.beginPath();
    for (var i = 5; i--;) {
        context.lineTo(0, this.length);
        context.translate(0, this.length);
        context.rotate((Math.PI * 2 / 10));
        context.lineTo(0, -this.length);
        context.translate(0, -this.length);
        context.rotate(-(Math.PI * 6 / 10));
    }
    context.lineTo(0, this.length);
    context.closePath();
    context.fillStyle = "rgba(255, 255, 200, " + this.opacity + ")";
    context.shadowBlur = 5;
    context.shadowColor = '#ffff33';
    context.fill();

    context.restore();
};