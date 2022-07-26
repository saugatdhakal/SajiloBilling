import { ref } from '@vue/reactivity';
import axios from 'axios';


const getUserList = () => {
    let users = ref([])
    const error = ref(null)

    const logedUser = async () => {
        await axios.get('api/getUsers', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((resUser) => {
            users.value = resUser.data;
            // console.log(users.value);
        }).catch((err) => {
            error.value = err.message;
        })
    }
    return { users, error, logedUser }
}
export default getUserList;
