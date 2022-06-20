// Editor JS Extensions
import Header from '@editorjs/header';
import List from '@editorjs/list';
import CodeTool from '@editorjs/code';
import Paragraph from '@editorjs/paragraph';
import Embed from '@editorjs/embed';
import Table from '@editorjs/table';
import Checklist from '@editorjs/checklist';
import Marker from '@editorjs/marker';
import Warning from '@editorjs/warning';
import RawTool from '@editorjs/raw';
import Quote from '@editorjs/quote';
import InlineCode from '@editorjs/inline-code';
import Delimiter from '@editorjs/delimiter';
import SimpleImage from '@editorjs/simple-image';
import ImageTool from '@editorjs/image';
import LinkTool from '@editorjs/link';
import axios from './axios.js';

const editorJSConfig = {
    holder: "content-editor",
    placeholder: 'Write your post here...',
    tools:{
        header: {
            class: Header,
            config: {
                placeholder: 'Enter a header',
                levels: [1, 2, 3, 4, 5],
                defaultLevel: 2,
            }
        },
        list: {
            class: List,
            inlineToolbar: true,
        },
        code: {
            class: CodeTool
        },
        paragraph: {
            class: Paragraph,
        },
        embed: {
            class: Embed,
            config: {
            services: {
                    youtube: true,
                    coub: true,
                    imgur: true
                }
            }
        },
        table: {
            class: Table,
            inlineToolbar: true,
            config: {
                rows: 2,
                cols: 3,
            },
        },
        checklist: {
            class: Checklist,
        },
        Marker: {
            class: Marker,
            shortcut: 'CMD+SHIFT+M',
        },
        warning: {
            class: Warning,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+W',
            config: {
                titlePlaceholder: 'Title',
                messagePlaceholder: 'Message',
            },
        },
        raw: RawTool,
        quote: {
            class: Quote,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+O',
            config: {
                quotePlaceholder: 'Enter a quote',
                captionPlaceholder: 'Quote\'s author',
            },
        },
        inlineCode: {
            class: InlineCode,
            shortcut: 'CMD+SHIFT+M',
        },
        delimiter: Delimiter,
        linkTool: {
            class: LinkTool,
            config: {
                endpoint: "",
            }
        },
        // image: SimpleImage,
        image: {
            class: ImageTool,
            config: {
                /**
                 * Custom uploader
                 */
                uploader: {
                    /**
                     * Upload file to the server and return an uploaded image data
                     * @param {File} file - file selected from the device or pasted by drag-n-drop
                     * @return {Promise.<{success, file: {url}}>}
                     */
                    async uploadByFile(file) {
                        const options = { headers: {'Content-Type': 'multipart/form-data' }};
                        const formData = new FormData();
                        formData.append('image', file);

                        let result = await axios.post(`/api/v1/utils/editorjs/upload/byfile`, formData, options)
                                .then(({ data }) => {
                                    const { message = 'Success!' } = data;
                                    
                                    return data.data;
                                }).catch(({ response: { data } }) => {
                                    const { message = 'Error!', errors = {} } = data;

                                    // TODO: Can't handle emit event here
                                    // this.$event.emit('flash-message', { message, type: "error", withToast: true });
                                    return data.data;
                                }).finally(() => {

                                });

                        return result;
                    },
                    /**
                     * Send URL-string to the server. Backend should load image by this URL and return an uploaded image data
                     * @param {string} url - pasted image URL
                     * @return {Promise.<{success, file: {url}}>}
                     */
                    async uploadByUrl(url) {
                        const options = { headers: {'Content-Type': 'multipart/form-data' }};
                        const formData = new FormData();
                        formData.append('url', url);

                        let result = await axios.post(`/api/v1/utils/editorjs/upload/byurl`, formData, options)
                                .then(({ data }) => {
                                    const { message = 'Success!' } = data;
                                    
                                    return data.data;
                                }).catch(({ response: { data } }) => {
                                    const { message = 'Error!', errors = {} } = data;

                                    // this.$event.emit('flash-message', { message, type: "error", withToast: true });
                                    return data.data;
                                }).finally(() => {

                                });

                        return result;
                    },
                }
            },
        },
    },
    onReady: () => {
        // console.log('Editor\'s content changed!');
    },
    onChange: (args) => {
        // console.log('Editor\'s content changed!');
    },
}

export {
    editorJSConfig,
};