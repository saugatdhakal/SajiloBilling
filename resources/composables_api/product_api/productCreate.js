import { ref } from '@vue/reactivity';
import axios from 'axios';
const registerProduct = () => {
    const product = ref({});
    const loading = ref(true);
    const productError = ref({});
    const createProduct = async (form) => {
        await axios.post('api/product/create', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            product.value = res.data;
            loading.value= false;
        }).catch((resErr) => {
            productError.value = resErr;
            loading.value= false;
        })
    }
    return { product, productError,loading, createProduct }
}
export default registerProduct;

