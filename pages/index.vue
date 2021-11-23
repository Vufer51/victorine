<template>

  <b-row align-v="center" no-gutters align-h="center"  class="vh-100">
    <b-col cols="auto">
      <b-button size="lg" to="question">Го</b-button>
    </b-col>
  </b-row>
</template>

<script>
export default {
  data: function () {
    return {
      questions: [],

    }
  },
  async created() {
    await this.loadQuestions()
    sessionStorage.setItem('questions', JSON.stringify(this.questions))
  },
  methods: {
    async loadQuestions() {
      this.questions = (await this.$axios.get(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/questions.json')).data
    }
  }
}
</script>
