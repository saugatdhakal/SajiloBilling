import { ref } from '@vue/reactivity';
import axios from 'axios';


const registerCategory = () => {
    const category = ref({});
    const loading = ref(true);
    const categoryError = ref({});

    const createCategory = async (form) => {
       axios.post('api/category/create', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            category.value = res.data;

        }).catch((resErr) => {
            loading.value = false;
            categoryError.value = resErr;
        })
    }
    return { category, loading,categoryError, createCategory }
}
export default registerCategory;

