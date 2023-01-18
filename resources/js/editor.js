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
    console.log(document.querySelector('#content')); //check if it can find the element
    submit.addEventListener('click', function(event){
        document.querySelector('#content').innerHTML = editor.getMarkdown();
    });
});