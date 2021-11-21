<template>
  <b-row align-v="center" no-gutters align-h="center"  class="vh-100">
    <b-col>
      <b-row>
        <b-col class="text-center">
          <h3>Вопрос</h3>
        </b-col>
      </b-row>
      <b-row>
        <b-button @click="loadQuestions">Загрузить</b-button>
        <b-col>{{quests}}</b-col>
      </b-row>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: "question",
  data: function () {
    return {
      quests:[],
    }
  },

  mounted() {
    this.loadQuestions()
  },
  methods: {
    async loadQuestions(){
      this.quests = (await this.$axios.get('questions.json')).data
    }
  }
}

</script>

<style scoped>

</style>
