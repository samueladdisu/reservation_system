async function filterRooms() {
  console.log(this.location);
  if (start && end) {
    if (this.room_quantity) {
      await axios.post('test.php', {
        "action": "filter",
        "location": "Bishoftu",
        "roomType": "",
        "checkin": "2023-09-01",
        "checkout": "2023-09-03",
        "roomQuantity": "10"
      }).then(res => {
        console.log(res.data);
      }).catch(err => console.log(err.message))
    }
  }


  console.log("filtered data", this.allData);
}


filterRooms()