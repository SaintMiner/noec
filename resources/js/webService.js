import axios from "axios";

let webService = axios.create({
    baseURL: "/api/"
})

export default webService;