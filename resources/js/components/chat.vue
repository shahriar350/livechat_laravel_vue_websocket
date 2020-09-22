<template>
    <div class="row">
        <div class="col-md-2 col-3">
            <p v-for="(user,index) in users" :key="index" class="bg-light text-capitalize bg-light py-2 my-2 px-2 cursor-pointer " :class="{'bg-dark text-light rounded' : user.id === select_user}" @click="user_chat(user.id)">
                {{user.name}}
            </p>
        </div>
        <div class="col-md-10 col-9 ">
            <div class="" style="top: 0">
                <p v-for="(message,index) in current_messages" class="h3">{{message}}</p>
            </div>
            <div class="" style="bottom: 0">
                <input placeholder="Your messages" v-model="message" type="text" class="form-control w-100" @keydown.enter="sendMessage()">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            user_id: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                users: [],
                select_user: 0,
                chats: [],
                message: '',
                current_messages: [],
            }
        },
        created() {
            this.all_users()
            window.Echo.private('send_message.'+this.user_id)
                .listen('MessageEvent', (e) => {
                    this.current_messages.push(e.message)
                });
        },
        mounted() {

        },
        methods: {
            sendMessage(){
                axios.post(`/user/message/broadcast/${this.select_user}`,{message: this.message})
                    .then(res => {
                        this.message = ''
                    })
            },
            all_users(){
                axios.get('/total/users')
                    .then(res => {
                        this.users = res.data.data
                        this.user_chat(this.users[0].id)
                    })
            },
            user_chat(id){
                this.select_user = id
                axios.get(`/all/chat/${id}`)
                    .then(res => {
                        this.chats.push(res.data.data)

                    })
            }
        }
    }
</script>

<style scoped>
    .cursor-pointer{
        cursor: pointer;
    }
    .vh-84{
        height: 84vh;
    }
    .w-97{
        width: 97% !important;
    }
</style>
