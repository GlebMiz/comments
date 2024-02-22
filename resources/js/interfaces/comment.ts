interface CommentFiles {
    type: 'txt' | 'image';
    name: string;
    path: string;
}

export interface Comment {
    name: string;
    email: string;
    date: string;
    text: string;
    files?: CommentFiles[];
    children?: Comment[];
}