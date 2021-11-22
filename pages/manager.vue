<template>
  <b-container>
    <b-row>
      <b-col class="h4 text-center">Новый вопрос</b-col>
    </b-row>
    <b-row align-h="center">
      <b-col >
        <b-row>
          <b-col>
            <b-form-input v-model="theme" placeholder="Тема"/>
          </b-col>
          <b-col>
            <b-form-input v-model="title" placeholder="Вопрос"/>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-row align-v="center">
              <b-col cols="auto">
                <b-form-checkbox v-model="answer" value="a"/>
              </b-col>
              <b-col>
                <b-form-input v-model="a" placeholder="Вариант А"/>
              </b-col>
            </b-row>
          </b-col>
          <b-col>
            <b-row align-v="center">
              <b-col cols="auto">
                <b-form-checkbox v-model="answer" value="b"/>
              </b-col>
              <b-col>
                <b-form-input v-model="b" placeholder="Вариант Б"/>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-row align-v="center">
              <b-col cols="auto">
                <b-form-checkbox v-model="answer" value="c"/>
              </b-col>
              <b-col>
                <b-form-input v-model="c" placeholder="Вариант В"/>
              </b-col>
            </b-row>
          </b-col>
          <b-col>
            <b-row align-v="center">
              <b-col cols="auto">
                <b-form-checkbox v-model="answer" value="d"/>
              </b-col>
              <b-col>
                <b-form-input v-model="d" placeholder="Вариант Г"/>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-form-input v-model="imageUrl" placeholder="Адрес картинки"/>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-form-textarea v-model="fact" placeholder="Факт"/>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-img :src="imageUrl" fluid/>
          </b-col>
          <b-col>
            Всего вопросов: {{questions.length}}
            <b-button @click="addQuestion" block>Добавить вопрос</b-button>
            <b-button @click="saveJSON" variant="primary" block>Сохранить файл</b-button>
          </b-col>
        </b-row>

      </b-col>
    </b-row>
    <b-row>
      <b-col>
        {{ questions }}
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  name: "manager",
  data: function () {
    return {
      theme: '',
      title: '',
      a: '',
      b: '',
      c: '',
      d: '',
      answer: '',
      imageUrl: '',
      fact: '',
      questions: [],
    }
  },
  mounted() {
    this.loadQuestions()
  },
  methods: {
    async loadQuestions() {
      this.questions = (await this.$axios.get(window.location.protocol+'//'+window.location.hostname+'/questions.json')).data
    },
    addQuestion() {
      this.questions.push({
        theme: this.theme,
        title: this.title,
        imageUrl: this.imageUrl,
        fact: this.fact,
        a: {title: this.a, correct: this.answer === 'a'},
        b: {title: this.b, correct: this.answer === 'b'},
        c: {title: this.c, correct: this.answer === 'c'},
        d: {title: this.d, correct: this.answer === 'd'},
      })
      this.theme = this.title = this.imageUrl = this.a = this.b = this.c = this.d = this.fact = ''
    },
    saveJSON() {
      function download(filename, text) {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
      }
      download('file.json',JSON.stringify(this.questions) )
    }

  }
}

</script>

<style scoped>

</style>
