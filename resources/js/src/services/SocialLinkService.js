import axios from "@src/plugin/axios";

class SocialLinkService {

    constructor() { }

    async create(payloads) {
        let success, failure = null;

        await axios.post(`/api/v1/social-link/create`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async show(userId) {
        let success, failure = null;

        await axios.get(`/api/v1/social-link/${userId}`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

}

export default SocialLinkService;