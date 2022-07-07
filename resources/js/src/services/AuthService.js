import axios from "@src/plugin/axios";

class AuthService {

    constructor() { }

    async csrfCookie() {
        let success, failure = null;

        await axios.get(`/sanctum/csrf-cookie`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async login(payloads) {
        let success, failure = null;

        await axios.post(`/login`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async register(payloads) {
        let success, failure = null;

        await axios.post(`/register`, payloads, { headers: {'Content-Type': 'multipart/form-data' }})
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async sendVerificationLink(payloads) {
        let success, failure = null;

        await axios.post(`/email/resend`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async verify(verifyUrl) {
        let success, failure = null;

        await axios.get(`${verifyUrl}`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async checkIfHasVerified() {
        let success, failure = null;

        await axios.get(`/checkIfHasVerified`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        return { success, failure }
    }

    async sendResetLink(payloads) {
        let success, failure = null;

        await axios.post(`/password/email`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);
        
        return { success, failure }
    }
    
    async resetPassword(payloads) {
        let success, failure = null;

        await axios.post(`/password/reset`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);
        
        return { success, failure }
    }

    async changePassword(payloads) {
        let success, failure = null;

        await axios.put(`/api/v1/user/password/change`, payloads)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);
        
        return { success, failure }
    }

    async user() {
        let success, failure = null;

        await axios.get(`/api/v1/user`)
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);
        
        return { success, failure }
    }

    async update(payloads, callback = null) {
        let success, failure = null;

        await axios.post(`/api/v1/user/update`, payloads, { headers: {'Content-Type': 'multipart/form-data' }})
                    .then(({ data }) => success = data)
                    .catch(({ response: { data } }) => failure = data);

        if (callback) {
            return callback(success, failure); 
        }

        return { success, failure }
    }

}

export default AuthService;