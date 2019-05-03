let chart = new Chart('chart');
let button = document.getElementById('pdf');

let category = new SlimSelect({
  select: "#category",
  onChange: (cat) => {
    let data = {
      kategori: cat.value
    }

    sendRequest();
    fetch('/get_report', {
      method: 'POST',
      body: JSON.stringify(data)
    })
    .then(resp => {
      return resp.json();
    })
    .then(resp => {
      generateChart(resp.arrayRes, cat.text);
    })
    .finally(() => {
      endRequest();
    })
  },
  placeholder: 'Pilih Kategori'
});

function sendRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.add('active');
}

function endRequest() {
  let loader = document.querySelector('.loader');
  loader.classList.remove('active');
}

function generateChart(resp, tex) {
  let data = {
    labels: [],
    datasets: [{
      label: ``,
      data: []
    }]
  }

  let options = {
    responsive: true,

    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          stepSize: 1
        }
      }]
    }
  }

  for (let qe of resp) {
    data.labels.push(qe.x);
    data.datasets[0].data.push(qe.y);
  }

  chart.destroy();

  chart = new Chart('chart', {
    type: 'bar',
    data,
    options
  });

  button.disabled = false;
  button.addEventListener('click', () => {
    downloadPDF();
  })
}

function downloadPDF() {
  var canvas = document.querySelector('#chart');
	//creates image
	var canvasImg = canvas.toDataURL("image/png", 1.0);
  
	//creates PDF from img
	var doc = new jsPDF('landscape');
	doc.setFontSize(20);
	doc.addImage(canvasImg, 'PNG', 10, 10, 280, 150 );
	doc.save('canvas.pdf');
}