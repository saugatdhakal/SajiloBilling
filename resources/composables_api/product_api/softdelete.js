import { ref } from '@vue/reactivity';
import axios from 'axios';
const softDelete = () => {
    const deletedProduct = ref([]);
    const deleteLoading = ref(false);
    const deletedError = ref({});
    const deleteProduct = async (id) => {
        axios.delete('api/product/softDelete/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deleteLoading.value = false;
            deletedProduct.value = res.data;
            // console.log(productCode.value);
        }).catch((resErr) => {
            deleteLoading.value = false;
            deletedError.value = resErr;
        })
    }
    return { deletedProduct, deleteLoading, deletedError, deleteProduct }
}
export default softDelete;
