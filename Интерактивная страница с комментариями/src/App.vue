<template>
  <img src="../images/1.jpg">
  <comment-form @submit="addComment"/>
  <hr>
  <comment-list :comments="this.comments" @delete="delRow"/>
</template>

<script>
import commentForm from "@/components/commentForm";
import commentList from "@/components/commentList";
import axios from "axios";
export default {
  data() {
    return {
      array: [], //массив с данными из comment-form
      comments: "", //массив комментариев, полученный из бд
    }
  },
  name: 'App',
  components: {
    commentForm,
    commentList
  },
  methods:{
    addComment(data){ //data - emit из comment-form
          this.array.push({ //записываем данные в массив
            name: data.name,
            comment: data.comment,
            date: data.date,
          })
          this.sendRequest(this.array) //и отправляем на сервер
          this.array=[]
      },
      async sendRequest(payload){ //функция отправки данных через axios
          this.comments=await axios.post('http://localhost:8080/src/php/main.php', payload) //передаем данные
            .then(function (response) {
              console.log(response)
              return response.data //получаем массив комментариев
            })
            .catch(function (response) {
              alert("Кажется, что-то пошло не так! Нажмите F12, чтобы увидеть подробности.")
              console.log(response)
            });
      },
      delRow(data){ //data - emit из comment-list
        this.sendRequest({id:data.id}) //при удалении просто передаем id комментария
      }
    },
    beforeMount(){
      this.sendRequest(null) //перед загрузкой страницы посылаем пустой запрос, чтобы получить массив комментариев
  },
  }
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
hr {
  border: none;
  border-top: 1px solid gainsboro;
}
</style>
