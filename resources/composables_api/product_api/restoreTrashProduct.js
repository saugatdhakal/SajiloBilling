import { ref } from '@vue/reactivity';
import axios from 'axios';

const restoreTrashProduct = () => {
    const restoredProduct = ref({});
    const loading = ref(true);
    const restoreProductError = ref({});
    const restore = async (id) => {
        await axios.post('api/product/restore/' + id,'', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            restoredProduct.value = res.data;
        }).catch((resErr) => {
            loading.value = false;
            restoreProductError.value = resErr;
        })
    }
    return { restoredProduct, loading, restoreProductError, restore }
}
export default restoreTrashProduct;
