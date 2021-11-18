<template>
    <span>
        <a href="#" v-if="isFavourited" @click.prevent="unFavourite(post)">
            <i  class="fa fa-heart"></i>
        </a>
        <a href="#" v-else @click.prevent="favourite(post)">
            <i  class="fa fa-heart-o"></i>
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