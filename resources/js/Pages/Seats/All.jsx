import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'

export default function Index ({ seats }) {
    const [searchQuery, setSearchQuery] = useState('')

    // Фильтрация сидений по номеру
    const filteredSeats = seats.data.filter(seat => {
        return seat.number.toString().includes(searchQuery)
    })

    return (
        <AuthenticatedLayout>
            <Head title='Seats' />
            <div style={{ padding: '20px' }}>
                {/* Поле для поиска сидений */}
                <div style={{ textAlign: 'center', marginBottom: '20px' }}>
                    <input
                        type='text'
                        placeholder='Search by seat number...'
                        value={searchQuery}
                        onChange={e => setSearchQuery(e.target.value)}
                        style={{
                            padding: '10px',
                            width: '300px',
                            borderRadius: '5px',
                            border: '1px solid #ccc',
                            fontSize: '16px'
                        }}
                    />
                </div>

                {/* Кнопка добавления нового сиденья */}
                <div style={{ textAlign: 'center', marginBottom: '20px' }}>
                    <Link
                        href={route('carriages.seats.create', {
                            carriage: seats.data[0].carriage_id
                        })}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#007bff',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px'
                        }}
                    >
                        <span style={{ marginRight: '5px' }}>+</span> Create
                        Seat
                    </Link>
                </div>

                {/* Отображение отфильтрованных мест */}
                <div
                    style={{
                        display: 'flex',
                        flexWrap: 'wrap',
                        justifyContent: 'center',
                        gap: '20px',
                        padding: '20px'
                    }}
                >
                    {filteredSeats.map((seat, index) => (
                        <Link
                            key={index}
                            href={route('carriages.seats.edit', {
                                seat: seat.id
                            })}
                            style={{
                                textDecoration: 'none',
                                display: 'block',
                                border: '1px solid #ccc',
                                borderRadius: '8px',
                                padding: '15px',
                                minWidth: '150px',
                                textAlign: 'center',
                                backgroundColor: seat.is_reserved
                                    ? '#f8d7da'
                                    : '#d4edda',
                                color: seat.is_reserved ? '#721c24' : '#155724'
                            }}
                        >
                            <h3 style={{ margin: '0 0 10px' }}>
                                Seat {seat.number}
                            </h3>
                            <p>
                                <strong>ID:</strong> {seat.id}
                            </p>
                            <p>
                                <strong>Reserved:</strong>{' '}
                                {seat.is_reserved ? 'Yes' : 'No'}
                            </p>
                        </Link>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
