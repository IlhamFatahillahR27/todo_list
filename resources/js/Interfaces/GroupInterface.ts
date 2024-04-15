import { TaskInterface } from "@/Interface/TaskInterface";
export interface GroupInterface {
    id: Number;
    title: String;
    color: String;
    for_complete: Boolean;
    is_default: Boolean;
    created_at: String;
    updated_at: String;
    tasks: Array<TaskInterface>;
}
