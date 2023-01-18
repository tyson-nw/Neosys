import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css';

const editor = new Editor({
    el: document.querySelector('#editor'),
    height: '200px',
    initialEditType: 'markdown',
    placeholder: '',
    initialValue: document.querySelector('#content').innerHTML,
})

addEventListener('DOMContentLoaded', (event) => {
    console.log('lookup element:');
    console.log(document.querySelector("input[name=content]")); //check if it can find the element
    console.log(document.querySelector('#editor')); //check if it can find the element
    submit.addEventListener('click', function(event){
        document.querySelector('input[name=content]').value = editor.getMarkdown();
        console.log(document.querySelector('input[name=content]').value)
    });
});
