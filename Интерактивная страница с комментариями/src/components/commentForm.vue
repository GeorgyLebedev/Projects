<template>
      <div id="comform">
          <h2>Оставить комментарий</h2>
          <input type="text" maxlength="100" v-model=name placeholder="Имя или никнейм"/> <br>
          <textarea rows="10" maxlength="1000" v-model="comment" placeholder="Комментарий"></textarea><br>
          <vue-recaptcha ref="recaptcha" @verify="capCheck" sitekey="6LeemBciAAAAAPKyUoJd_WyrZbuPgeBps51czG1H"></vue-recaptcha >
          <button class="confirm" @click="Submit" :disabled="!(comment.trim().length && name.trim().length)" type="button">Добавить</button>
      </div>
</template>

<script>
import  { VueRecaptcha } from 'vue-recaptcha'
export default {
  components: {VueRecaptcha},
  name: 'commentForm',
  emits:['submit'],
  captcha:"",
  data() {
    return {
      comment: '',
      name: ''
    }
  },
  methods:{
     Submit(){
      if(!this.comment || !this.name){ //если вдруг комментарий или имя пустое, а кнопка оказалась доступна
        alert("Комментарий или имя не заполнено!")
        return
      }
      if(!this.captcha){ //проверим прохождение капчи
        alert("Капча не пройдена или пройдена некорректно!")
        return
      }
      this.$emit('submit',{ //оптправляем имя, текст комментария и дату в родительский компонент
        name:this.name,
        comment: this.comment,
        date:Date.now()/1000
      })
      this.$refs.recaptcha.reset(); //очищаем форму
      this.name=this.comment=this.captcha=""
    },
    capCheck(response){
      this.captcha=response; //пишем ответ на прохождение капчи
    }
  }
}
</script>

<style scoped>
#comform{
  font-family: "Roboto";
  width: 50%;
  margin:0 auto;
  text-align: left;
}
.confirm{
  font-family: "Roboto";
  background-color: mediumseagreen;
  border: 1px solid #00945b;
  border-radius: 5px;
  margin-top:1%;
  padding: 5px;
  font-size: 12pt;
  color: white;
  cursor: pointer;
}
.confirm:disabled{
  background-color: darkgray;
  border: 1px solid gray;
  cursor: default;
}
input, textarea {
  font-family: "Roboto";
  font-size: 11pt;
  background-color: #f7f7f7;
  margin-bottom: 1%;
  width: 100%;
  min-height: 30px;
  resize: none;
  border: 1px solid gainsboro;
  border-radius: 10px;
  padding-left: 5px;
  outline: none;
}
</style>
