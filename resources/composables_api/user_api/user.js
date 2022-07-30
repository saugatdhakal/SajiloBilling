import { ref } from '@vue/reactivity';
import axios from 'axios';
import { computed } from 'vue';


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

    const getAdminCount = computed(() => users.value.filter((user) => user.role === '1').length);
    const getStaffCount = computed(() => users.value.filter((user) => user.role === '0').length);
    const getTotalUserCount = computed(() => users.value.length);

    return { users, error, logedUser, getAdminCount, getStaffCount, getTotalUserCount }
}
export default getUserList;
