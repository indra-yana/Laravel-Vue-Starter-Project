import axios from "../plugin/axios";

class PostService {

    constructor() { }

    async create(data) {
        let success, failure = null;

        await axios.post(`/api/v1/post/create`, data, { headers: { 'Content-Type': 'multipart/form-data' }})
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async update(data) {
        let success, failure = null;

        await axios.post(`/api/v1/post/update`, data, { headers: {'Content-Type': 'multipart/form-data' }})
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async show(id) {
        let success, failure = null;

        await axios.get(`/api/v1/post/${id}/show`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async posts(page = 1) {
        let success, failure = null;

        await axios.get(`/api/v1/post?page=${page}`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);
        
        return { success, failure }
    }

    async dataTable() {
        let success, failure = null;

        await axios.get(`/api/v1/post/dt-table.json`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

}

export default PostService;