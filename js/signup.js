
const app = Vue.createApp({
  data(){
    return {
      form: {
        fName: '',
        lName: '',
        email: '',
        phone: '',
        dob: '',
        mType: '',
        uName: '',
        cName: '',
        pwd: '',
      },
      cPwd: '',
      pwdError: '',
      cPwdError: ''
    }
  },
  methods: {
    checkPwd(){
      if(this.form.pwd.length < 5 ){
        this.pwdError = "Password must be at least 5 chars long"
      }else {
        this.pwdError = ""
      }
    },
    confirmPwd(){
      if(this.form.pwd != this.cPwd){
        this.cPwdError = "Password doesn't match"
      }else {
        this.cPwdError = ""
      }
    },
    async submitForm(){
      if(this.pwdError == "" && this.cPwdError == ""){
        console.log(this.form);
      }

      await axios.post('member.php', {
        action: 'insert',
        data: this.form 
      }).then(res => {
        console.log(res.data);
        this.form = {}
        this.cPwd = ""

        // for(let key in this.form){
        //   let value = this.form[key]
        //   value = ""
        // }
      }).catch(err => {
        console.log(err.message);
      })
    },
    showPwd(){
      if(this.$refs.pwd.type == "password"){
        this.$refs.pwd.type = "text"
      }else {
        this.$refs.pwd.type = "password"
      }
    }
  }
})

app.mount('#form-wiget')