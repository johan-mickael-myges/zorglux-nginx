import { Controller } from "@hotwired/stimulus";
import Quill from 'quill';

export default class extends Controller {
  static targets = ["editor", "input"];
  static values = { options: Object };

  DEFAULT_OPTIONS = {
    theme: 'snow',
    modules: {
      toolbar: [
        [
          {'header': '2'}, {'header': '3'},
        ],
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' },
          { 'indent': '-1'}, { 'indent': '+1' }],
        ['link', 'image', 'blockquote'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'align': [] }],
        ['clean']
      ],
      clipboard: {
        matcher: null
      },
      history: {
        delay: 2000,
        maxStack: 500,
        userOnly: true
      },
      'image-tooltip': true,
      'link-tooltip': true,
    },
    readOnly: false,
    formats: [
      'header', 'font', 'size', 'bold', 'italic', 'underline', 'strike',
      'blockquote', 'list', 'bullet', 'indent', 'link', 'image', 'color', 'background', 'align'
    ],
  }

  connect() {
    this.configure();
  }

  configure() {
    const options = { ...this.DEFAULT_OPTIONS, ...this.optionsValue };
    this.editor = new Quill(this.editorTarget, options);

    // on editor change, update the hidden input, by event listener
    this.editor.on('text-change',  () => {
      this.inputTarget.value = this.editor.root.innerHTML;
    });
  }
}
