<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Branch;
use App\Models\Course;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Students';

    protected static ?string $modelLabel = 'Student';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'student');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->label(fn (string $operation) => $operation === 'create' ? 'Password' : 'New Password (leave blank to keep current)'),
                        Forms\Components\Select::make('branch_id')
                            ->label('Branch')
                            ->options(Branch::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\Select::make('course_id')
                            ->label('Registered Course')
                            ->options(Course::where('is_published', true)->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Profile Photo')
                    ->schema([
                        Forms\Components\FileUpload::make('student_detail_image')
                            ->label('')
                            ->image()
                            ->disk('public')
                            ->directory('student-photos')
                            ->avatar()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Personal Details')
                    ->relationship('studentDetail')
                    ->schema([
                        Forms\Components\TextInput::make('name_with_initials')
                            ->label('Name with Initials')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('full_name')
                            ->label('Full Name')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->maxDate(now()),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male'   => 'Male',
                                'female' => 'Female',
                                'other'  => 'Other',
                            ]),
                        Forms\Components\TextInput::make('id_number')
                            ->label('NIC / ID Number')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('past_school')
                            ->label('Past School')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Educational Qualifications')
                    ->relationship('studentDetail')
                    ->schema([
                        Forms\Components\Repeater::make('educational_qualifications')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('institution')
                                    ->label('Institution')
                                    ->required(),
                                Forms\Components\TextInput::make('qualification')
                                    ->label('Qualification')
                                    ->required(),
                                Forms\Components\TextInput::make('year')
                                    ->label('Year')
                                    ->maxLength(10),
                            ])
                            ->columns(3)
                            ->addActionLabel('Add Qualification')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Work Experience')
                    ->relationship('studentDetail')
                    ->schema([
                        Forms\Components\Repeater::make('work_experience')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('company')
                                    ->label('Company')
                                    ->required(),
                                Forms\Components\TextInput::make('position')
                                    ->label('Position')
                                    ->required(),
                                Forms\Components\TextInput::make('start_date')
                                    ->label('Start Date'),
                                Forms\Components\TextInput::make('end_date')
                                    ->label('End Date'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2)
                                    ->columnSpan(2),
                            ])
                            ->columns(3)
                            ->addActionLabel('Add Experience')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Emergency Contacts')
                    ->relationship('studentDetail')
                    ->schema([
                        Forms\Components\Repeater::make('emergency_contacts')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone')
                                    ->tel()
                                    ->required(),
                                Forms\Components\TextInput::make('relationship')
                                    ->label('Relationship'),
                            ])
                            ->columns(3)
                            ->addActionLabel('Add Emergency Contact')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Courses Enrolled')
                    ->counts('enrollments')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('payments_count')
                    ->label('Total Payments')
                    ->counts('payments')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('completed_payments_count')
                    ->label('Completed Payments')
                    ->counts([
                        'payments' => fn (Builder $query) => $query->where('status', 'completed')
                    ])
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('module_completions_count')
                    ->label('Modules Completed')
                    ->counts('moduleCompletions')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('quiz_attempts_count')
                    ->label('Quiz Attempts')
                    ->counts('quizAttempts')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('average_quiz_score')
                    ->label('Avg Quiz Score')
                    ->getStateUsing(function (User $record) {
                        $avgScore = $record->quizAttempts()->avg('score');
                        return $avgScore ? number_format($avgScore, 1) . '%' : 'N/A';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->withAvg('quizAttempts', 'score')
                            ->orderBy('quiz_attempts_avg_score', $direction);
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'N/A') => 'gray',
                        floatval($state) >= 80 => 'success',
                        floatval($state) >= 60 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('Branch')
                    ->options(Branch::pluck('name', 'id'))
                    ->placeholder('All Branches')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('has_enrollments')
                    ->label('Has Enrollments')
                    ->placeholder('All Students')
                    ->trueLabel('With Enrollments')
                    ->falseLabel('No Enrollments')
                    ->queries(
                        true: fn (Builder $query) => $query->has('enrollments'),
                        false: fn (Builder $query) => $query->doesntHave('enrollments'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('has_completions')
                    ->label('Module Completions')
                    ->placeholder('All Students')
                    ->trueLabel('Has Completions')
                    ->falseLabel('No Completions')
                    ->queries(
                        true: fn (Builder $query) => $query->has('moduleCompletions'),
                        false: fn (Builder $query) => $query->doesntHave('moduleCompletions'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\SelectFilter::make('enrollment_count')
                    ->label('Enrollment Count')
                    ->options([
                        '1' => '1+ courses',
                        '3' => '3+ courses',
                        '5' => '5+ courses',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            return $query->has('enrollments', '>=', (int)$data['value']);
                        }
                        return $query;
                    }),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View'),
                
                Tables\Actions\Action::make('view_progress')
                    ->label('View Progress')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->url(fn (User $record): string => StudentResource::getUrl('progress', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\StudentResource\RelationManagers\QuizAttemptsRelationManager::class,
            \App\Filament\Resources\StudentResource\RelationManagers\AttendanceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'    => Pages\ListStudents::route('/'),
            'create'   => Pages\CreateStudent::route('/create'),
            'edit'     => Pages\EditStudent::route('/{record}/edit'),
            'view'     => Pages\ViewStudent::route('/{record}'),
            'progress' => Pages\StudentProgress::route('/{record}/progress'),
        ];
    }
}
