<template>
  <h2>Комментарии ({{comments.length}})</h2>
<div class="comment" v-for="comment in comments" :key=comment.comment_id>
  <div class="top">
  <b>{{comment.author_name}}</b><br>
    <span class="date">{{comment.comment_date}}</span>
  </div>
  <hr>
  <div class="middle">
    {{comment.comment_text}}
    <div class="down">
      <button :id="`b${comment.comment_id}`" @click="Delete($event)" class="delete">Удалить</button>
    </div>
  </div>

</div>

</template>

<script>
export default {
  name: 'commentList',
  id:"",
  emits:['delete'],
  props:{
    comments: {
      type:Array,
      required:true
    }
},
  methods:{
    Delete(e){
      this.id=e.target.id.substr(1) //обращаемся к id нажатой кнопки
      this.$emit('delete', {id:this.id}) //и передаем id в родительский компонент
    }
  }
}
</script>

<style scoped>
.comment{
  font-family: "Roboto";
  font-size: 11pt;
  text-align: left;
  background-color: #f7f7f7;
  width: 50%;
  min-height: 30px;
  resize: none;
  border: 1px solid gainsboro;
  border-radius: 10px;
  margin:0 auto;
  margin-top:10px;
}
.date{
  color:gray;
}
hr {
  margin: 1px 0;
  border: none;
  border-top: 1px solid gainsboro;
}
h2{
  text-align: left;
  margin-left: 25%;
}
.top{
  margin:10px 10px;
}
.middle{
  margin:10px
}
.down{
  text-align: right;
}
button{
  margin-right: 10px;
}
.delete{
  font-family: "Roboto";
  background-color: #ff4d4d;
  border: 1px solid #cc0000;
  border-radius: 5px;
  padding: 5px;
  font-size: 12pt;
  color: white;
  cursor: pointer;
}
.delete:disabled{
  background-color: darkgray;
  border: 1px solid gray;
  cursor: default;
}
</style>
