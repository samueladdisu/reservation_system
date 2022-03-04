const ctx = document.getElementById("myAreaChart").getContext("2d")

const labels = [
  '2016',
  '2017',
  '2018',
  '2019',
  '2020',
  '2021',
  '2022'
]

const data = {
  labels,
  dataSets: [{
    data: [211, 326, 165, 350, 420,370, 500, 374],
    label: 'Kuriftu Sales'
  }]
}

const config = {
  type: 'line',
  data: data,
  options: {
    responsive: true,
  }
}

const myc