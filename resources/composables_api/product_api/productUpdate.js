import { ref } from '@vue/reactivity';
import axios from 'axios';
const registerProductUpdate = () => {
    const product = ref({});
    const loading = ref(true);
    const productError = ref({});
    const updateProduct = async ({ id, form }) => {
        console.log(form);
        await axios.post('api/product/update/' + id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            product.value = res.data;
            loading.value = false;
            // console.log(product.value);
        }).catch((resErr) => {
            productError.value = resErr;
            loading.value = false;
        })
    }
    return { product, productError, loading, updateProduct }
}
export default registerProductUpdate;

