import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function CreateCarriage({ train }) {
    const { data, setData, post, processing, reset, errors } = useForm({
        train_id: train.id,
        number: '',
        class: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('trains.carriages.store', train.id), {
            onSuccess: () => {
                alert('Carriage created successfully!');
                reset();
            },
            onError: () => {
                alert('Failed to create carriage. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Carriage" />

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
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>
                    Create Carriage for Train {train.id}
                </h2>

                <form onSubmit={handleSubmit}>
                    {/* Carriage Number */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="number"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Carriage Number:
                        </label>
                        <input
                            type="text"
                            id="number"
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

                    {/* Carriage Class */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="class"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Carriage Class:
                        </label>
                        <input
                            type="text"
                            id="class"
                            value={data.class}
                            onChange={(e) => setData('class', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.class && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.class}
                            </div>
                        )}
                    </div>

                    {/* Submit Button */}
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
                        {processing ? 'Creating...' : 'Create Carriage'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
