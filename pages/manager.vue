<template>
  <b-container>
    <b-row>
      <b-col class="h4 text-center">Новый вопрос</b-col>
    </b-row>
    <b-row align-h="center">
      <b-col>
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
            Всего вопросов: {{ questions.length }}
            <b-button block @click="addQuestion">Добавить вопрос</b-button>
            <b-button block variant="primary" @click="saveJSON">Сохранить файл</b-button>
          </b-col>
        </b-row>

      </b-col>
    </b-row>
    <b-row class="mt-3">
      <b-col>
        <b-list-group>
          <b-list-group-item v-for="(item,n) in questions" :key="n">
            <b-row>
              <b-col>{{ item.title }}</b-col>
              <b-col cols="auto">
                <b-button size="sm" variant="danger" @click="deleteItem(n)">Удалить</b-button>
              </b-col>
            </b-row>
          </b-list-group-item>
        </b-list-group>
      </b-col>
    </b-row>
    {{ this.questions }}
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
      sessionStorage.clear()
      this.questions = (await this.$axios.get(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/questions.json?a='+ new Date() )).data
      //this.questions.splice(0, this.questions.length, ...questions_new)

    },
    async addQuestion() {
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
      let sendForm = new FormData;
      sendForm.append('question', JSON.stringify({
          theme: this.theme,
          title: this.title,
          imageUrl: this.imageUrl,
          fact: this.fact,
          a: {title: this.a, correct: this.answer === 'a'},
          b: {title: this.b, correct: this.answer === 'b'},
          c: {title: this.c, correct: this.answer === 'c'},
          d: {title: this.d, correct: this.answer === 'd'},
        }
      ))
      // this.$axios.post(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/db_builder.php?action=add', {
      await this.$axios({
        method: "post",
        url: window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/db_builder.php?action=add',
        data: sendForm,
        headers: {"Content-Type": "multipart/form-data"},

      }).then(res => {
        //this.questions.push(JSON.parse(res.data))
        this.loadQuestions()
      })

      this.theme = this.title = this.imageUrl = this.a = this.b = this.c = this.d = this.fact = ''
    },
    saveJSON() {
      function download(filename, text) {
        let element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
      }

      download('file.json', JSON.stringify(this.questions))
    },
    async deleteItem(itemNNumber) {
      await this.$axios.get(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/db_builder.php?action=remove&number='+itemNNumber)
      this.questions.splice(itemNNumber, 1)
    }

  }
}

</script>

<style scoped>

</style>
