import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({trains, carriage}) {
    console.log(trains, carriage);
    return (
        <AuthenticatedLayout>
            <Head title="Edit Carriage"/>
            Edit Carriage
        </AuthenticatedLayout>
    );
}
