

let checkBoxArray = []

const app = Vue.createApp({
  data() {
    return {
      msg: "hello world"
    }
  }
})

app.mount('#app')


window.addEventListener('load', () => {
  // getData()
  const book = document.querySelector('#book')
  const location = document.querySelector('#location')
  const checkBoxes = document.querySelectorAll('.checkBoxes')
  const selectAllBoxes = document.querySelector('#selectAllboxes')
  selectAllBoxes.addEventListener('click', function () {
    if (this.checked) {
      console.log("all");
      checkBoxes.forEach(check => {
        check.checked = true
        console.log(check.value);
      })
    } else {
      checkBoxes.forEach(check => {
        check.checked = false
        console.log(check.value);
      })
    }
  })
  location.addEventListener('click', function (e) {
    e.preventDefault()
    axios.post('load_modal.php', {
      action: 'filter',

    })

  })
  book.addEventListener('click', function (e) {

    e.preventDefault()
    checkBoxes.forEach(check => {

      if (check.checked) {
        checkBoxArray.push(check.value)
        document.cookie = "checkBoxArray = " + checkBoxArray
        axios.post('load_modal.php', {
          action: 'update',
          data: checkBoxArray,
        }).catch(err => console.log(err.message))
      } else {
        console.log('not');
      }

    })

  })



})





// function getData(){
//   $.ajax({
//     type: "GET",
//     url: "./includes/load_avialable_rooms.php",
//     data: '',
//     beforeSend: function() {

//     },
//     complete: function() {

//     },
//     success: function(data) {
//       $(".insert-data").html(data);
//       $(".checkBoxes")
//     }
//   })
// }
