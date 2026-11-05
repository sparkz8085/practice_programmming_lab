import java.util.*;
public class rowhigh 
{
    public static void main(String args[]) 
    {
        Scanner sc = new Scanner(System.in);
        System.out.println("enter row size: ");
        int row = sc.nextInt();
        System.out.println("enter column size: ");
        int col = sc.nextInt();
        int ind=0;
        int arr[][] = new int[row][col];
	for (int i=0;i<row;i++)
	{
		for(int j=0;j<col;j++)
		{
			System.out.println("enter value"+ind+": ");
			arr[i][j]=sc.nextInt();
			ind++;
		}
	}
        System.out.println("entered values - ");
        for (int i = 0; i < row; i++) 
        {
            for (int j = 0; j < col; j++) 
            {
                System.out.print(arr[i][j] + "\t");
            }
            System.out.println();
        }
        System.out.println("highest elements are - ");
        for (int i = 0; i < row; i++) 
        {
            int max = arr[i][0];
            for (int j = 1; j < col; j++) 
            {
                if (arr[i][j] > max) 
                {
                    max = arr[i][j];
                }
            }
            System.out.println("element =" + max+"is highest from"+(i+1)+"row.");
        }
    }
}
