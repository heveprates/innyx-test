import { CategoryNotFoundError } from "@/error/CategoryNotFoundError";
import { Server } from "./serviceAPI";

export class CategoryAPIFetch {
  static async listPage(
    page: number,
    search: string
  ): Promise<CategoryFetchResponse> {
    try {
      const {
        data: { data, meta },
      } = await Server.APIAuthInstance.get<CategoryAPIFetchData>(
        `/api/categories`,
        {
          params: {
            page,
            search: search || undefined,
          },
        }
      );
      return {
        data: data.map((category: CategoryAPIResponse) => ({
          id: String(category.id),
          name: category.name,
        })),
        pagination: {
          current: meta.current_page,
          last: meta.last_page,
          total: meta.total,
        },
      };
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }

  static async all(): Promise<Category[]> {
    try {
      const {
        data: { data },
      } = await Server.APIAuthInstance.get<{ data: CategoryAPIResponse[] }>(
        `/api/categories`,
        {
          params: {
            all: true,
          },
        }
      );
      return data.map((category: CategoryAPIResponse) => ({
        id: String(category.id),
        name: category.name,
      }));
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }

  static async store(category: { name: string }): Promise<string> {
    try {
      const formData = new FormData();
      formData.append("name", category.name);
      const { data } = await Server.APIAuthInstance.post<CategoryAPIResponse>(
        `/api/categories`,
        formData
      );
      return String(data.id);
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }

  static async show(id: string): Promise<Category> {
    try {
      const { data } = await Server.APIAuthInstance.get<{
        category: CategoryAPIResponse;
      }>(`/api/categories/${id}`);
      return {
        id: String(data.category.id),
        name: data.category.name,
      };
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }

  static async update(id: string, category: { name: string }): Promise<string> {
    try {
      const formData = new FormData();
      formData.append("name", category.name);
      formData.append("_method", "PUT");
      await Server.APIAuthInstance.post(`/api/categories/${id}`, formData);
      return id;
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }

  static async delete(id: string): Promise<void> {
    try {
      await Server.APIAuthInstance.delete(`/api/categories/${id}`);
    } catch (error: any) {
      if (error?.response?.status) throw new CategoryNotFoundError();
      throw error;
    }
  }
}

type CategoryAPIFetchData = {
  data: CategoryAPIResponse[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
};

type CategoryFetchResponse = {
  data: Category[];
  pagination: {
    current: number;
    last: number;
    total: number;
  };
};

type Category = {
  id: string;
  name: string;
};

type CategoryAPIResponse = {
  id: number;
  name: string;
};
