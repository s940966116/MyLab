<template>
    <div class="body">
        <div>
            <div class="top-frame">
                <div>
                    <ul>
                        <li>首頁</li>
                    </ul>
                </div>
            </div>
            <input @click='logout' type="button" value="登出">
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            //登出方法
            logout: function(){
                var upper = this;
                axios.get('cancelLoginSession')
                    .then((response) => {
                        if(response.data.logout){
                            upper.$router.push("login");
                        }
                    })
                    .catch((error) => {})
            }
        },
    }
</script>

<style scoped>
    .top-frame {
        background-color: red;
    }

    div.top-frame ul{
        list-style-type: none;
    }
</style>