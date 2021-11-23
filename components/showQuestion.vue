<template>
  <b-container>
    <b-card>
      <b-card-sub-title>{{ question.theme }}</b-card-sub-title>
      <b-card-title class="text-center">{{ question.title }}</b-card-title>
      <b-card-body>
        <b-list-group>
          <b-list-group-item href="#" :variant="isThis(question.a)" @click="clicked=true">{{ question.a.title }}
          </b-list-group-item>
          <b-list-group-item href="#" :variant="isThis(question.b)" @click="clicked=true">{{ question.b.title }}
          </b-list-group-item>
          <b-list-group-item href="#" :variant="isThis(question.c)" @click="clicked=true">{{ question.c.title }}
          </b-list-group-item>
          <b-list-group-item href="#" :variant="isThis(question.d)" @click="clicked=true">{{ question.d.title }}
          </b-list-group-item>
        </b-list-group>
      </b-card-body>
      <b-card-footer v-show="clicked">
        <b-btn block @click="moreQuest()">Еще!</b-btn>
        {{ question.fact }}
        <b-card-img :src="question.imageUrl"/>

      </b-card-footer>
    </b-card>
  </b-container>
</template>

<script>
export default {
  name: "showQuestion",
  props: {
    question: {
      type: Object,
      default: function () {
        return {
          title: '',
          theme: '',
          a: {title: ''},
          b: {title: ''},
          c: {title: ''},
          d: {title: ''},
          imageUrl: '',
          false: '',
        }
      }
    }
  },
  data() {
    return {
      clicked: false,

    }
  },
  mounted() {
    console.log(this.question);
  },
  methods: {
    moreQuest() {
      this.clicked=false
      this.$emit('newQuest')
    },
    isThis(click) {
      return this.clicked ? click.correct ? "success" : "danger" : ''
    }
  }
}
</script>

<style scoped>

</style>
