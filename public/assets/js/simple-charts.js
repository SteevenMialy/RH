// Simple Charts - Graphiques hors ligne avec HTML5 Canvas
// Aucune dépendance externe requise

function drawBarChart(canvas, data, labels, title) {
    const ctx = canvas.getContext('2d');
    const width = canvas.width = 500;
    const height = canvas.height = 300;
    ctx.clearRect(0, 0, width, height);
    
    const margin = { top: 50, right: 20, bottom: 50, left: 50 };
    const chartWidth = width - margin.left - margin.right;
    const chartHeight = height - margin.top - margin.bottom;
    const maxValue = Math.max(...data, 1);
    
    // Titre
    ctx.fillStyle = '#333';
    ctx.font = 'bold 16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(title, width / 2, 30);
    
    // Axes
    ctx.strokeStyle = '#666';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(margin.left, margin.top);
    ctx.lineTo(margin.left, height - margin.bottom);
    ctx.lineTo(width - margin.right, height - margin.bottom);
    ctx.stroke();
    
    // Barres
    const barWidth = chartWidth / data.length - 10;
    data.forEach((value, index) => {
        const x = margin.left + index * (chartWidth / data.length) + 5;
        const barHeight = (value / maxValue) * chartHeight;
        const y = height - margin.bottom - barHeight;
        
        ctx.fillStyle = '#4a90d9';
        ctx.fillRect(x, y, barWidth, barHeight);
        
        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(value, x + barWidth / 2, y - 5);
        
        ctx.fillStyle = '#333';
        ctx.font = '11px Arial';
        ctx.fillText(labels[index], x + barWidth / 2, height - margin.bottom + 20);
    });
}

function drawLineChart(canvas, data, labels, title) {
    const ctx = canvas.getContext('2d');
    const width = canvas.width = 500;
    const height = canvas.height = 300;
    ctx.clearRect(0, 0, width, height);
    
    const margin = { top: 50, right: 20, bottom: 50, left: 50 };
    const chartWidth = width - margin.left - margin.right;
    const chartHeight = height - margin.top - margin.bottom;
    const maxValue = Math.max(...data, 1);
    
    // Titre
    ctx.fillStyle = '#333';
    ctx.font = 'bold 16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(title, width / 2, 30);
    
    // Axes
    ctx.strokeStyle = '#666';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(margin.left, margin.top);
    ctx.lineTo(margin.left, height - margin.bottom);
    ctx.lineTo(width - margin.right, height - margin.bottom);
    ctx.stroke();
    
    // Points
    const points = data.map((value, index) => ({
        x: margin.left + index * (chartWidth / (data.length - 1)),
        y: height - margin.bottom - (value / maxValue) * chartHeight
    }));
    
    // Ligne
    ctx.strokeStyle = '#e74c3c';
    ctx.lineWidth = 3;
    ctx.beginPath();
    points.forEach((point, index) => {
        if (index === 0) ctx.moveTo(point.x, point.y);
        else ctx.lineTo(point.x, point.y);
    });
    ctx.stroke();
    
    // Points et labels
    points.forEach((point, index) => {
        ctx.fillStyle = '#e74c3c';
        ctx.beginPath();
        ctx.arc(point.x, point.y, 5, 0, Math.PI * 2);
        ctx.fill();
        
        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(data[index], point.x, point.y - 15);
        
        ctx.fillStyle = '#333';
        ctx.font = '11px Arial';
        ctx.fillText(labels[index], point.x, height - margin.bottom + 20);
    });
}
