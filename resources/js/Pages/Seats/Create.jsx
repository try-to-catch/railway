import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function CreateSeat({ carriages }) {
    const { data, setData, post, processing, errors } = useForm({
        number: '',
        is_reserved: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('carriages.seats.store', { carriage: carriages[0].id }), {
            onSuccess: () => {
                alert('Seat created successfully!');
            },
            onError: () => {
                alert('Failed to create seat. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Seat" />

            <div
                style={{
                    maxWidth: '600px',
                    margin: '20px auto',
                    padding: '20px',
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    backgroundColor: '#f8f9fa',
                }}
            >
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>Create Seat</h2>
                <form onSubmit={handleSubmit}>
                   
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="seatNumber"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Seat Number:
                        </label>
                        <input
                            type="text"
                            id="seatNumber"
                            value={data.number}
                            onChange={(e) => setData('number', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.number && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.number}
                            </div>
                        )}
                    </div>

                    {/* Reserved Checkbox */}
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px' }}>
                            Is Reserved:
                        </label>
                        <input
                            type="checkbox"
                            id="isReserved"
                            checked={data.is_reserved}
                            onChange={(e) => setData('is_reserved', e.target.checked)}
                        />
                        {errors.is_reserved && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.is_reserved}
                            </div>
                        )}
                    </div>
                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            display: 'block',
                            width: '100%',
                            padding: '10px',
                            backgroundColor: '#007bff',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: processing ? 'not-allowed' : 'pointer',
                        }}
                    >
                        {processing ? 'Creating...' : 'Create Seat'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
