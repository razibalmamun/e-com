import Vue from 'vue';
import VueQuillEditor from 'vue-quill-editor';
import VueHtml2pdf from 'vue-html2pdf';
import VueConfirmDialog from 'vue-confirm-dialog';

Vue.use(VueQuillEditor);
Vue.use(VueHtml2pdf);
Vue.use(VueConfirmDialog);

export default ({ app }) => {
    Vue.use(VueConfirmDialog);
}

