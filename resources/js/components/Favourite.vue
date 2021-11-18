<template>
    <span>
        <a href="#" v-if="isFavourited" @click.prevent="unFavourite(post)">
                    <i class="material-icons">favorite</i>                    
        </a>
        <a href="#" v-else @click.prevent="favourite(post)">
                    <i class="material-icons">favorite</i>                    
        </a>
    </span>
</template>

<script>
    export default {
        props: ['post', 'favourited'],

        data: function() {
            return {
                isFavourited: '',
            }
        },

        mounted() {
            console.log('Fav component mounted.')
            this.isFavourited = this.isFavourite ? true : false;
        },

        computed: {
            isFavourite() {
                return this.favourited;
            },
        },

        methods: {
            favourite(post) {
                axios.post('/favourite/'+post)
                    .then(response => this.isFavourited = true)
                    .catch(response => console.log(response.data));
            },

            unFavourite(post) {
                axios.post('/unfavourite/'+post)
                    .then(response => this.isFavourited = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>