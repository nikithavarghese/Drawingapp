const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext('2d');
const shapeSelect = document.getElementById('shape');
const colorPicker = document.getElementById('color');

let isDrawing = false;
let startX = 0;
let startY = 0;
let savedImage = null;
let history = [];

canvas.addEventListener('mousedown', (e) => {
  const rect = canvas.getBoundingClientRect();
  startX = e.clientX - rect.left;
  startY = e.clientY - rect.top;
  isDrawing = true;

  history.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
});

canvas.addEventListener('mousemove', (e) => {
  if (!isDrawing) return;

  const rect = canvas.getBoundingClientRect();
  const currentX = e.clientX - rect.left;
  const currentY = e.clientY - rect.top;
  const width = currentX - startX;
  const height = currentY - startY;

  if (history.length > 0) {
    ctx.putImageData(history[history.length - 1], 0, 0);
  } else {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  }

  ctx.strokeStyle = colorPicker.value;
  ctx.fillStyle = colorPicker.value;
  const shape = shapeSelect.value;

  if (shape === 'line') {
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(currentX, currentY);
    ctx.stroke();
  } else if (shape === 'rectangle') {
    ctx.fillRect(startX, startY, width, height);
  } else if (shape === 'square') {
    const size = Math.min(Math.abs(width), Math.abs(height));
    ctx.fillRect(startX, startY, width < 0 ? -size : size, height < 0 ? -size : size);
  } else if (shape === 'circle') {
    const radius = Math.sqrt(width * width + height * height) / 2;
    const centerX = startX + width / 2;
    const centerY = startY + height / 2;
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
    ctx.fill();
  } else if (shape === 'triangle') {
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(currentX, currentY);
    ctx.lineTo(startX * 2 - currentX, currentY);
    ctx.closePath();
    ctx.fill();
  }
});

canvas.addEventListener('mouseup', () => {
  isDrawing = false;
});

function undo() {
  if (history.length > 0) {
    ctx.putImageData(history.pop(), 0, 0);
  } else {
    clearCanvas();
  }
}

function clearCanvas() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  history = [];
}