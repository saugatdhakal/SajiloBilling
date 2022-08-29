import { ref } from '@vue/reactivity';
import axios from 'axios';

const forceDeleteProduct = () => {
    const deletedProduct = ref({});
    const productError = ref({});
    const deletePro = async (id) => {
        await axios.delete('api/product/forceDelete/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deletedProduct.value = res.data;
        }).catch((resErr) => {
            productError.value = resErr;
        })
    }
    return { deletedProduct,productError, deletePro }
}
export default forceDeleteProduct;
