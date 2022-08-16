import { ref } from '@vue/reactivity';
import axios from 'axios';

const updateSupplier = () => {
    const supplier = ref({});
    const loading = ref(true);
    const supplierError = ref({});

    const update = async ({ form, id }) => {
        await axios.post('api/supplier/supplierUpdate/' + id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            supplier.value = res.data;
        }).catch((resErr) => {
            loading.value = false;

            supplierError.value = resErr;
        })

    }
    return { supplier,loading, supplierError, update }
}
export default updateSupplier;
