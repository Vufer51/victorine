<template>
  <b-container fluid>
  <b-row align-v="center" no-gutters align-h="center" class="vh-100">
    <b-col>
      <b-row>
        <b-col class="text-center">
          <h3>Вопрос</h3>
        </b-col>
      </b-row>
      <b-row>
        <b-col v-if="randomQuestion">
          <show-question :question="randomQuestion" @newQuest="getRandomQuestion"/>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
  </b-container>
</template>

<script>
export default {
  name: "question",
  data: function () {
    return {
      questions: JSON.parse(sessionStorage.getItem('questions')),
      randomQuestion:null,
    }
  },

  async mounted() {
  //  await this.loadQuestions()
    this.getRandomQuestion()
  },
  methods: {
    getRandomQuestion () {
      this.randomQuestion=this.questions[Math.floor(Math.random() * this.questions.length)]
      console.log(this.randomQuestion);
    },
    // async loadQuestions() {
    //   this.questions = (await this.$axios.get(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/questions.json')).data
    // }
  }
}

</script>

<style scoped>

</style>
